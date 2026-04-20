<?php

namespace App\Http\Controllers;

use App\Http\Requests\IdentifyFontRequest;
use App\Models\SearchHistory;
use App\Services\FontIdentificationService;
use App\Services\PdfFirstPageImageExtractor;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Inertia\Inertia;

class FontController extends Controller
{
    public function __construct(
        private FontIdentificationService $fontService,
        private PdfFirstPageImageExtractor $pdfFirstPageImageExtractor
    ) {}

    public function index()
    {
        return Inertia::render('HomePage');
    }

    public function identify(IdentifyFontRequest $request): JsonResponse
    {
        $uploadedFile = $request->file('image');
        $file = $uploadedFile;

        if ($file->getClientOriginalExtension() === 'pdf') {
            try {
                $file = $this->pdfFirstPageImageExtractor->extract($file);
            } catch (\Throwable) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se pudo procesar el PDF. Verifica que el archivo sea válido e inténtalo nuevamente.',
                ], 400);
            }
        }

        $result = $this->fontService->identify($file);

        if (Auth::check() && ($result['success'] ?? false) === true) {
            $imageReference = $uploadedFile->getClientOriginalName();

            try {
                $fileToPersist = $file;
                $imageReference = $fileToPersist->store('images/history', 'public');
            } catch (\Throwable) {
                // Mantener compatibilidad en caso de fallo al persistir imagen.
            }

            SearchHistory::create([
                'user_id' => Auth::id(),
                'image_reference' => $imageReference,
                'font_results' => [
                    'success' => $result['success'] ?? false,
                    'fonts' => $result['fonts'] ?? [],
                    'total_found' => $result['total_found'] ?? 0,
                ],
            ]);
        }

        $status = $result['status'] ?? ($result['success'] ? 200 : 200);
        unset($result['status']);

        return response()->json($result, $status);
    }

    public function history(Request $request)
    {
        $histories = $request->user()
            ->searchHistories()
            ->latest()
            ->paginate(10)
            ->through(fn (SearchHistory $history) => [
                'id' => $history->id,
                'image_reference' => $history->image_reference,
                'image_url' => $this->resolveHistoryImageUrl($history->image_reference),
                'font_results' => $history->font_results,
                'created_at' => $history->created_at,
            ]);

        return Inertia::render('HistoryDashboard', [
            'histories' => $histories,
        ]);
    }

    private function resolveHistoryImageUrl(?string $imageReference): ?string
    {
        if (! is_string($imageReference) || $imageReference === '') {
            return null;
        }

        if (Str::startsWith($imageReference, ['http://', 'https://', '/'])) {
            return $imageReference;
        }

        if (Str::startsWith($imageReference, ['images/', 'uploads/'])) {
            return asset('storage/'.$imageReference);
        }

        return null;
    }
}
