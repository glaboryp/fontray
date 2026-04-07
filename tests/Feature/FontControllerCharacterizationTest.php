<?php

namespace Tests\Feature;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class FontControllerCharacterizationTest extends TestCase
{
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

    public function test_homepage_returns_200_with_inertia_homepage(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertInertia(fn (Assert $page) => $page->component('HomePage'));
    }

    public function test_identify_requires_image(): void
    {
        $response = $this->postJson('/identify', []);

        $response->assertStatus(422);
    }

    public function test_identify_returns_fonts_on_success(): void
    {
        $fixtureData = json_decode(
            file_get_contents(base_path('tests/Fixtures/whatfontis_success_response.json')),
            true
        );

        Http::fake([
            'https://www.whatfontis.com/*' => Http::response($fixtureData, 200),
        ]);

        $response = $this->postJson('/identify', ['image' => $this->fakeImage()]);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
        $response->assertJsonCount(3, 'fonts');
        $response->assertJsonPath('total_found', 3);

        $fonts = $response->json('fonts');
        foreach ($fonts as $font) {
            $this->assertArrayHasKey('name', $font);
            $this->assertArrayHasKey('similarity', $font);
            $this->assertArrayHasKey('link', $font);
            $this->assertArrayHasKey('preview', $font);
            $this->assertArrayHasKey('category', $font);
            $this->assertArrayHasKey('foundry', $font);
        }
    }

    public function test_identify_returns_error_when_image_too_large(): void
    {
        $errorBody = file_get_contents(base_path('tests/Fixtures/whatfontis_error_too_large.txt'));

        Http::fake([
            'https://www.whatfontis.com/*' => Http::response($errorBody, 400),
        ]);

        $response = $this->postJson('/identify', ['image' => $this->fakeImage()]);

        $response->assertStatus(400);
        $response->assertJson(['success' => false]);
    }

    public function test_identify_returns_error_when_no_text_detected(): void
    {
        $errorBody = file_get_contents(base_path('tests/Fixtures/whatfontis_error_no_text.txt'));

        Http::fake([
            'https://www.whatfontis.com/*' => Http::response($errorBody, 400),
        ]);

        $response = $this->postJson('/identify', ['image' => $this->fakeImage()]);

        $response->assertStatus(400);
        $response->assertJson(['success' => false]);
    }

    public function test_identify_returns_error_when_no_chars_found(): void
    {
        $errorBody = file_get_contents(base_path('tests/Fixtures/whatfontis_error_no_chars.txt'));

        Http::fake([
            'https://www.whatfontis.com/*' => Http::response($errorBody, 400),
        ]);

        $response = $this->postJson('/identify', ['image' => $this->fakeImage()]);

        $response->assertStatus(400);
        $response->assertJson(['success' => false]);
    }

    public function test_identify_returns_error_when_rate_limited(): void
    {
        $errorBody = file_get_contents(base_path('tests/Fixtures/whatfontis_error_rate_limit.txt'));

        Http::fake([
            'https://www.whatfontis.com/*' => Http::response($errorBody, 429),
        ]);

        $response = $this->postJson('/identify', ['image' => $this->fakeImage()]);

        $response->assertStatus(429);
        $response->assertJson(['success' => false]);
    }

    public function test_identify_returns_error_on_api_failure(): void
    {
        Http::fake([
            'https://www.whatfontis.com/*' => Http::response('Internal Server Error', 500),
        ]);

        $response = $this->postJson('/identify', ['image' => $this->fakeImage()]);

        $response->assertStatus(500);
        $response->assertJson(['success' => false]);
    }

    public function test_identify_returns_error_on_empty_results(): void
    {
        Http::fake([
            'https://www.whatfontis.com/*' => Http::response([], 200),
        ]);

        $response = $this->postJson('/identify', ['image' => $this->fakeImage()]);

        $response->assertJson(['success' => false]);
    }

    public function test_identify_handles_exception_gracefully(): void
    {
        Http::fake(function () {
            throw new \RuntimeException('Simulated network failure');
        });

        $response = $this->postJson('/identify', ['image' => $this->fakeImage()]);

        $response->assertStatus(500);
        $response->assertJson(['success' => false]);
    }
}
