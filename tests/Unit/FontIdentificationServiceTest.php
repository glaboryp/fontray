<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\FontIdentificationService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;

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
        $this->assertEquals('Roboto Regular', $result['fonts'][0]['name']);
    }
}
