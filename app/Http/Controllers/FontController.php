<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FontIdentificationService;
use Inertia\Inertia;

class FontController extends Controller
{
    public function __construct(
        private FontIdentificationService $fontService
    ) {}

    public function index()
    {
        return Inertia::render('HomePage');
    }

    public function identify(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:10240',
        ]);

        $result = $this->fontService->identify($request->file('image'));

        $status = $result['status'] ?? ($result['success'] ? 200 : 200);
        unset($result['status']);

        return response()->json($result, $status);
    }
}
