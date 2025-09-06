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
                Log::error('WhatFontIs API Error', [
                    'status' => $response->status(),
                    'response' => $response->body()
                ]);
                
                return response()->json([
                    'success' => false,
                    'message' => 'Error al procesar la imagen. Por favor, inténtalo de nuevo.'
                ], 500);
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
