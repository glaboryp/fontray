<?php

namespace Tests\Feature;

use App\Services\FontIdentificationService;
use App\Services\PdfFirstPageImageExtractor;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Inertia\Testing\AssertableInertia as Assert;
use Mockery\MockInterface;
use Tests\TestCase;

class FontControllerTest extends TestCase
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

    public function test_homepage_renders_with_inertia(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertInertia(fn (Assert $page) => $page->component('HomePage'));
    }

    public function test_results_page_renders(): void
    {
        $response = $this->get('/results');

        $response->assertStatus(200);
        $response->assertInertia(fn (Assert $page) => $page->component('ResultsPage'));
    }

    public function test_examples_page_renders(): void
    {
        $response = $this->get('/examples');

        $response->assertStatus(200);
        $response->assertInertia(fn (Assert $page) => $page->component('ExamplesPage'));
    }

    public function test_privacy_page_renders(): void
    {
        $response = $this->get('/privacy');

        $response->assertStatus(200);
        $response->assertInertia(fn (Assert $page) => $page->component('PrivacyPage'));
    }

    public function test_terms_page_renders(): void
    {
        $response = $this->get('/terms');

        $response->assertStatus(200);
        $response->assertInertia(fn (Assert $page) => $page->component('TermsPage'));
    }

    public function test_identify_validates_image_required(): void
    {
        $response = $this->postJson('/identify', []);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('image');
    }

    public function test_identify_validates_image_type(): void
    {
        $file = UploadedFile::fake()->create('document.txt', 100, 'text/plain');

        $response = $this->postJson('/identify', ['image' => $file]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('image');
    }

    public function test_identify_success_returns_json_with_fonts(): void
    {
        Http::fake([
            'https://www.whatfontis.com/*' => Http::response(
                json_decode(file_get_contents(base_path('tests/Fixtures/whatfontis_success_response.json')), true),
                200
            ),
        ]);

        $response = $this->postJson('/identify', [
            'image' => $this->fakeImage(),
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'total_found' => 3,
        ]);
        $response->assertJsonCount(3, 'fonts');
        $response->assertJsonStructure([
            'success',
            'fonts' => [['name', 'similarity', 'link', 'preview', 'category', 'foundry']],
            'total_found',
        ]);
    }

    public function test_identify_api_error_returns_appropriate_status(): void
    {
        Http::fake([
            'https://www.whatfontis.com/*' => Http::response('Image too large', 400),
        ]);

        $response = $this->postJson('/identify', [
            'image' => $this->fakeImage(),
        ]);

        $response->assertStatus(400);
        $response->assertJson(['success' => false]);
    }

    public function test_identify_rate_limit_returns_429(): void
    {
        Http::fake([
            'https://www.whatfontis.com/*' => Http::response('API rate limit exceeded', 429),
        ]);

        $response = $this->postJson('/identify', [
            'image' => $this->fakeImage(),
        ]);

        $response->assertStatus(429);
        $response->assertJson(['success' => false]);
    }

    public function test_identify_accepts_pdf_and_extracts_first_page_before_identification(): void
    {
        $pdf = UploadedFile::fake()->create('sample.pdf', 500, 'application/pdf');
        $firstPageImage = UploadedFile::fake()->create('sample-page-1.png', 120, 'image/png');

        $this->mock(PdfFirstPageImageExtractor::class, function (MockInterface $mock) use ($pdf, $firstPageImage) {
            $mock->shouldReceive('extract')
                ->once()
                ->withArgs(fn (UploadedFile $file) => $file->getClientOriginalName() === $pdf->getClientOriginalName())
                ->andReturn($firstPageImage);
        });

        $this->mock(FontIdentificationService::class, function (MockInterface $mock) {
            $mock->shouldReceive('identify')
                ->once()
                ->withArgs(function (UploadedFile $file) {
                    $mime = $file->getMimeType() ?? '';

                    return str_starts_with($mime, 'image/');
                })
                ->andReturn([
                    'success' => true,
                    'fonts' => [],
                    'total_found' => 0,
                ]);
        });

        $response = $this->postJson('/identify', [
            'image' => $pdf,
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'total_found' => 0,
        ]);
    }

    public function test_identify_returns_friendly_error_when_pdf_extraction_fails(): void
    {
        $pdf = UploadedFile::fake()->create('sample.pdf', 500, 'application/pdf');

        $this->mock(PdfFirstPageImageExtractor::class, function (MockInterface $mock) {
            $mock->shouldReceive('extract')
                ->once()
                ->andThrow(new \RuntimeException('Imagick PDF delegate missing'));
        });

        $this->mock(FontIdentificationService::class, function (MockInterface $mock) {
            $mock->shouldNotReceive('identify');
        });

        $response = $this->postJson('/identify', [
            'image' => $pdf,
        ]);

        $response->assertStatus(400);
        $response->assertJson([
            'success' => false,
        ]);
        $response->assertJsonPath('message', 'No se pudo procesar el PDF. Verifica que el archivo sea válido e inténtalo nuevamente.');
    }
}
