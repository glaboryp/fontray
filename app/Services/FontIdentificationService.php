<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FontIdentificationService
{
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
                'limit' => '20'
            ]);

            if (!$response->successful()) {
                $errorMessage = $response->body();

                Log::error('WhatFontIs API Error', [
                    'status' => $response->status(),
                    'response' => $errorMessage
                ]);

                if (strpos($errorMessage, 'too large') !== false) {
                    return [
                        'success' => false,
                        'message' => 'La imagen es demasiado grande. Por favor, usa una imagen más pequeña o de menor resolución.',
                        'status' => 400,
                    ];
                } elseif (strpos($errorMessage, 'No text box detected') !== false) {
                    return [
                        'success' => false,
                        'message' => 'No se detectó texto en la imagen. Asegúrate de que la imagen contenga texto claro y legible.',
                        'status' => 400,
                    ];
                } elseif (strpos($errorMessage, 'No characters detected') !== false || strpos($errorMessage, 'No Characters Found') !== false || strpos($errorMessage, 'No chars found') !== false) {
                    return [
                        'success' => false,
                        'message' => 'No se detectaron caracteres legibles en la imagen. Esta herramienta funciona mejor con texto normal en lugar de logotipos muy estilizados. Intenta con una imagen que contenga texto más convencional.',
                        'status' => 400,
                    ];
                } elseif (strpos($errorMessage, 'API rate limit exceeded') !== false) {
                    return [
                        'success' => false,
                        'message' => 'Se ha alcanzado el límite de consultas diarias. Por favor, inténtalo mañana.',
                        'status' => 429,
                    ];
                } else {
                    return [
                        'success' => false,
                        'message' => 'Error al procesar la imagen. Por favor, inténtalo de nuevo con una imagen diferente.',
                        'status' => 500,
                    ];
                }
            }

            $data = $response->json();

            if (empty($data) || !is_array($data)) {
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
                    'foundry' => null
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
                'trace' => $e->getTraceAsString()
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
