<?php

namespace Tests\Unit\WhatFontIs;

use App\Services\WhatFontIs\FontApiError;
use App\Services\WhatFontIs\FontApiErrorClassifier;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class FontApiErrorClassifierTest extends TestCase
{
    private function classifier(): FontApiErrorClassifier
    {
        return new FontApiErrorClassifier;
    }

    public static function bodyProvider(): array
    {
        return [
            'rate limit text' => ['API rate limit exceeded', 400, FontApiError::RateLimit],
            'image too large' => ['Image too large', 400, FontApiError::ImageTooLarge],
            'no text box detected' => ['No text box detected', 400, FontApiError::NoTextDetected],
            'no characters detected' => ['No characters detected', 400, FontApiError::NoCharactersDetected],
            'no Characters Found variant' => ['No Characters Found', 400, FontApiError::NoCharactersDetected],
            'no chars found variant' => ['No chars found', 400, FontApiError::NoCharactersDetected],
            'unrecognized body' => ['Internal Server Error', 500, FontApiError::Unknown],
        ];
    }

    #[DataProvider('bodyProvider')]
    public function test_classifies_known_body_needles(string $body, int $status, FontApiError $expected): void
    {
        $this->assertSame($expected, $this->classifier()->classify($status, $body));
    }

    public function test_a_429_status_is_always_classified_as_rate_limit_even_without_known_text(): void
    {
        $result = $this->classifier()->classify(429, 'Too Many Requests');

        $this->assertSame(FontApiError::RateLimit, $result);
    }

    public function test_rate_limit_text_takes_priority_over_other_needles_in_the_same_body(): void
    {
        $result = $this->classifier()->classify(400, 'rate limit reached: image too large to retry');

        $this->assertSame(FontApiError::RateLimit, $result);
    }
}
