<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class FontController extends Controller {

    public function index() {
        return Inertia::render('HomePage');
    }

    public function identify(Request $request) {
        $request->validate([
            'image' => 'required|image|max:10240', // 10MB max
        ]);

        try {
            $image = $request->file('image');
            
            // Preparar la imagen en base64
            $imageBase64 = base64_encode(file_get_contents($image->getRealPath()));
            
            // Preparar la petición a WhatFontIs API
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
                
                // Manejar errores específicos de la API
                if (strpos($errorMessage, 'too large') !== false) {
                    return response()->json([
                        'success' => false,
                        'message' => 'La imagen es demasiado grande. Por favor, usa una imagen más pequeña o de menor resolución.'
                    ], 400);
                } elseif (strpos($errorMessage, 'No text box detected') !== false) {
                    return response()->json([
                        'success' => false,
                        'message' => 'No se detectó texto en la imagen. Asegúrate de que la imagen contenga texto claro y legible.'
                    ], 400);
                } elseif (strpos($errorMessage, 'No characters detected') !== false || strpos($errorMessage, 'No Characters Found') !== false || strpos($errorMessage, 'No chars found') !== false) {
                    return response()->json([
                        'success' => false,
                        'message' => 'No se detectaron caracteres legibles en la imagen. Esta herramienta funciona mejor con texto normal en lugar de logotipos muy estilizados. Intenta con una imagen que contenga texto más convencional.'
                    ], 400);
                } elseif (strpos($errorMessage, 'API rate limit exceeded') !== false) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Se ha alcanzado el límite de consultas diarias. Por favor, inténtalo mañana.'
                    ], 429);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Error al procesar la imagen. Por favor, inténtalo de nuevo con una imagen diferente.'
                    ], 500);
                }
            }

            $data = $response->json();
            
            // Verificar si se encontraron fuentes
            if (empty($data) || !is_array($data)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se pudieron identificar fuentes en esta imagen. Asegúrate de que el texto sea claro y legible.'
                ]);
            }

            // Procesar y limpiar los resultados
            $fonts = collect($data)->map(function ($font) {
                return [
                    'name' => $font['title'] ?? 'Fuente desconocida',
                    'similarity' => 100, // WhatFontIs no proporciona similarity score
                    'link' => $font['url'] ?? null,
                    'preview' => $font['image'] ?? null,
                    'category' => 'Sin categoría',
                    'foundry' => null
                ];
            })->values();

            return response()->json([
                'success' => true,
                'fonts' => $fonts,
                'total_found' => count($fonts)
            ]);

        } catch (\Exception $e) {
            Log::error('Font identification error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error interno del servidor. Por favor, inténtalo de nuevo más tarde.'
            ], 500);
        }
    }

}
