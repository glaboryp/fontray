<?php

namespace App\Services\WhatFontIs;

enum FontApiError
{
    case RateLimit;
    case ImageTooLarge;
    case NoTextDetected;
    case NoCharactersDetected;
    case Unknown;

    public function httpStatus(): int
    {
        return match ($this) {
            self::RateLimit => 429,
            self::ImageTooLarge, self::NoTextDetected, self::NoCharactersDetected => 400,
            self::Unknown => 500,
        };
    }

    public function message(): string
    {
        return match ($this) {
            self::RateLimit => 'Has alcanzado temporalmente el límite de solicitudes. Por favor, inténtalo más tarde.',
            self::ImageTooLarge => 'La imagen es demasiado grande. Por favor, usa una imagen más pequeña o de menor resolución.',
            self::NoTextDetected => 'No se detectó texto en la imagen. Asegúrate de que la imagen contenga texto claro y legible.',
            self::NoCharactersDetected => 'No se detectaron caracteres legibles en la imagen. Esta herramienta funciona mejor con texto normal en lugar de logotipos muy estilizados. Intenta con una imagen que contenga texto más convencional.',
            self::Unknown => 'Error al procesar la imagen. Por favor, inténtalo de nuevo con una imagen diferente.',
        };
    }
}
