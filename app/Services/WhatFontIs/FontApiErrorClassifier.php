<?php

namespace App\Services\WhatFontIs;

class FontApiErrorClassifier
{
    /**
     * Substrings observed in WhatFontIs error responses, checked in order.
     * Keyed by needle rather than status code because the provider reports
     * most error kinds as a 400 with a distinguishing message in the body.
     *
     * @var array<string, FontApiError>
     */
    private const BODY_NEEDLES = [
        'rate limit' => FontApiError::RateLimit,
        'too large' => FontApiError::ImageTooLarge,
        'no text box detected' => FontApiError::NoTextDetected,
        'no characters detected' => FontApiError::NoCharactersDetected,
        'no characters found' => FontApiError::NoCharactersDetected,
        'no chars found' => FontApiError::NoCharactersDetected,
    ];

    public function classify(int $statusCode, string $body): FontApiError
    {
        if ($statusCode === 429) {
            return FontApiError::RateLimit;
        }

        foreach (self::BODY_NEEDLES as $needle => $error) {
            if (stripos($body, $needle) !== false) {
                return $error;
            }
        }

        return FontApiError::Unknown;
    }
}
