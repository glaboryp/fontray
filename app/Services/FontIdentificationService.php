<?php

namespace App\Services;

use App\Services\WhatFontIs\FontApiErrorClassifier;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FontIdentificationService
{
    public function __construct(
        private FontApiErrorClassifier $errorClassifier
    ) {}

    public function identify(UploadedFile $image): array
    {
        if (config('services.whatfontis.mock')) {
            return $this->mockResponse();
        }

        try {
            $imageBase64 = base64_encode(file_get_contents($image->getRealPath()));

            $response = Http::asForm()->post('https://www.whatfontis.com/api2/', [
                'API_KEY' => config('services.whatfontis.api_key'),
                'IMAGEBASE64' => '1',
                'NOTTEXTBOXSDETECTION' => '0',
                'urlimage' => '',
                'urlimagebase64' => $imageBase64,
                'limit' => '20',
            ]);

            if (! $response->successful()) {
                $errorMessage = $response->body();
                $statusCode = $response->status();

                Log::error('WhatFontIs API Error', [
                    'status' => $statusCode,
                    'response' => $errorMessage,
                ]);

                $error = $this->errorClassifier->classify($statusCode, $errorMessage);

                return [
                    'success' => false,
                    'message' => $error->message(),
                    'status' => $error->httpStatus(),
                ];
            }

            $data = $response->json();

            if (empty($data) || ! is_array($data)) {
                return [
                    'success' => false,
                    'message' => 'No se pudieron identificar fuentes en esta imagen. Asegúrate de que el texto sea claro y legible.',
                ];
            }

            $fonts = collect($data)->map(function ($font) {
                return [
                    'name' => $font['title'] ?? 'Fuente desconocida',
                    'similarity' => 100,
                    'link' => $font['url'] ?? null,
                    'preview' => $font['image'] ?? null,
                    'category' => 'Sin categoría',
                    'foundry' => null,
                ];
            })->values();

            return [
                'success' => true,
                'fonts' => $fonts,
                'total_found' => count($fonts),
            ];

        } catch (\Exception $e) {
            Log::error('Font identification error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return [
                'success' => false,
                'message' => 'Error interno del servidor. Por favor, inténtalo de nuevo más tarde.',
                'status' => 500,
            ];
        }
    }

    private function mockResponse(): array
    {
        $fonts = collect([
            ['name' => 'Roboto Regular', 'similarity' => 100, 'link' => 'https://www.whatfontis.com/Roboto-Regular.font', 'preview' => 'https://www.whatfontis.com/preview/Roboto-Regular.png', 'category' => 'Sin categoría', 'foundry' => null],
            ['name' => 'Open Sans', 'similarity' => 100, 'link' => 'https://www.whatfontis.com/Open-Sans.font', 'preview' => 'https://www.whatfontis.com/preview/Open-Sans.png', 'category' => 'Sin categoría', 'foundry' => null],
            ['name' => 'Lato', 'similarity' => 100, 'link' => 'https://www.whatfontis.com/Lato.font', 'preview' => 'https://www.whatfontis.com/preview/Lato.png', 'category' => 'Sin categoría', 'foundry' => null],
        ]);

        return [
            'success' => true,
            'fonts' => $fonts,
            'total_found' => count($fonts),
        ];
    }
}
