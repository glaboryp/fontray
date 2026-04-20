<?php

namespace Tests\Unit;

use App\Services\FontIdentificationService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class FontIdentificationServiceTest extends TestCase
{
    private function makeService(): FontIdentificationService
    {
        return app(FontIdentificationService::class);
    }

    private function fakeImage(): UploadedFile
    {
        return new UploadedFile(
            base_path('tests/Fixtures/test_image.jpg'),
            'test.jpg',
            'image/jpeg',
            null,
            true
        );
    }

    public function test_identify_returns_fonts_on_success(): void
    {
        Http::fake([
            'https://www.whatfontis.com/*' => Http::response(
                json_decode(file_get_contents(base_path('tests/Fixtures/whatfontis_success_response.json')), true),
                200
            ),
        ]);

        $result = $this->makeService()->identify($this->fakeImage());

        $this->assertTrue($result['success']);
        $this->assertCount(3, $result['fonts']);
        $this->assertEquals(3, $result['total_found']);
    }

    public function test_identify_sends_correct_params_to_whatfontis(): void
    {
        Http::fake([
            'https://www.whatfontis.com/*' => Http::response([['title' => 'Test', 'url' => 'http://test', 'image' => 'http://img']], 200),
        ]);

        $this->makeService()->identify($this->fakeImage());

        Http::assertSent(function ($request) {
            return $request->url() === 'https://www.whatfontis.com/api2/'
                && $request['IMAGEBASE64'] === '1'
                && $request['NOTTEXTBOXSDETECTION'] === '0'
                && $request['limit'] === '20'
                && ! empty($request['urlimagebase64']);
        });
    }

    public function test_identify_maps_response_to_font_array(): void
    {
        Http::fake([
            'https://www.whatfontis.com/*' => Http::response(
                json_decode(file_get_contents(base_path('tests/Fixtures/whatfontis_success_response.json')), true),
                200
            ),
        ]);

        $result = $this->makeService()->identify($this->fakeImage());
        $font = $result['fonts'][0];

        $this->assertEquals('Roboto Regular', $font['name']);
        $this->assertEquals(100, $font['similarity']);
        $this->assertEquals('https://www.whatfontis.com/Roboto-Regular.font', $font['link']);
        $this->assertEquals('https://www.whatfontis.com/preview/Roboto-Regular.png', $font['preview']);
        $this->assertEquals('Sin categoría', $font['category']);
        $this->assertNull($font['foundry']);
    }

    public function test_identify_returns_error_when_image_too_large(): void
    {
        Http::fake([
            'https://www.whatfontis.com/*' => Http::response('Image too large', 400),
        ]);

        $result = $this->makeService()->identify($this->fakeImage());

        $this->assertFalse($result['success']);
        $this->assertEquals(400, $result['status']);
        $this->assertStringContainsString('demasiado grande', $result['message']);
    }

    public function test_identify_returns_error_when_no_text_detected(): void
    {
        Http::fake([
            'https://www.whatfontis.com/*' => Http::response('No text box detected', 400),
        ]);

        $result = $this->makeService()->identify($this->fakeImage());

        $this->assertFalse($result['success']);
        $this->assertEquals(400, $result['status']);
        $this->assertStringContainsString('No se detectó texto', $result['message']);
    }

    public function test_identify_returns_error_when_no_chars_found(): void
    {
        Http::fake([
            'https://www.whatfontis.com/*' => Http::response('No Characters Found', 400),
        ]);

        $result = $this->makeService()->identify($this->fakeImage());

        $this->assertFalse($result['success']);
        $this->assertEquals(400, $result['status']);
        $this->assertStringContainsString('No se detectaron caracteres', $result['message']);
    }

    public function test_identify_returns_error_when_no_chars_found_variant(): void
    {
        Http::fake([
            'https://www.whatfontis.com/*' => Http::response('No chars found', 400),
        ]);

        $result = $this->makeService()->identify($this->fakeImage());

        $this->assertFalse($result['success']);
        $this->assertEquals(400, $result['status']);
    }

    public function test_identify_returns_error_when_rate_limited(): void
    {
        Http::fake([
            'https://www.whatfontis.com/*' => Http::response('API rate limit exceeded', 429),
        ]);

        $result = $this->makeService()->identify($this->fakeImage());

        $this->assertFalse($result['success']);
        $this->assertEquals(429, $result['status']);
        $this->assertStringContainsString('límite de solicitudes', $result['message']);
    }

    public function test_identify_returns_friendly_rate_limit_message_for_429_without_known_provider_text(): void
    {
        Http::fake([
            'https://www.whatfontis.com/*' => Http::response('Too Many Requests', 429),
        ]);

        $result = $this->makeService()->identify($this->fakeImage());

        $this->assertFalse($result['success']);
        $this->assertEquals(429, $result['status']);
        $this->assertStringContainsString('límite de solicitudes', $result['message']);
        $this->assertStringNotContainsString('Too Many Requests', $result['message']);
    }

    public function test_identify_returns_error_on_generic_api_failure(): void
    {
        Http::fake([
            'https://www.whatfontis.com/*' => Http::response('Internal Server Error', 500),
        ]);

        $result = $this->makeService()->identify($this->fakeImage());

        $this->assertFalse($result['success']);
        $this->assertEquals(500, $result['status']);
    }

    public function test_identify_returns_error_on_empty_results(): void
    {
        Http::fake([
            'https://www.whatfontis.com/*' => Http::response([], 200),
        ]);

        $result = $this->makeService()->identify($this->fakeImage());

        $this->assertFalse($result['success']);
        $this->assertArrayNotHasKey('status', $result);
    }

    public function test_identify_handles_exception_gracefully(): void
    {
        Http::fake([
            'https://www.whatfontis.com/*' => function () {
                throw new \RuntimeException('Connection failed');
            },
        ]);

        $result = $this->makeService()->identify($this->fakeImage());

        $this->assertFalse($result['success']);
        $this->assertEquals(500, $result['status']);
        $this->assertStringContainsString('Error interno', $result['message']);
    }

    public function test_identify_sets_similarity_to_100(): void
    {
        Http::fake([
            'https://www.whatfontis.com/*' => Http::response(
                [['title' => 'Test Font', 'url' => 'http://test', 'image' => 'http://img']],
                200
            ),
        ]);

        $result = $this->makeService()->identify($this->fakeImage());

        $this->assertEquals(100, $result['fonts'][0]['similarity']);
    }

    public function test_identify_uses_unknown_font_as_default_name(): void
    {
        Http::fake([
            'https://www.whatfontis.com/*' => Http::response(
                [['url' => 'http://test', 'image' => 'http://img']],
                200
            ),
        ]);

        $result = $this->makeService()->identify($this->fakeImage());

        $this->assertEquals('Fuente desconocida', $result['fonts'][0]['name']);
    }
}
