<?php

namespace Tests\Unit;

use App\Services\PdfFirstPageImageExtractor;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class PdfFirstPageImageExtractorTest extends TestCase
{
    private function makeExtractor(): PdfFirstPageImageExtractor
    {
        return app(PdfFirstPageImageExtractor::class);
    }

    private function fakePdf(): UploadedFile
    {
        return new UploadedFile(
            base_path('tests/Fixtures/blank_page.pdf'),
            'blank_page.pdf',
            'application/pdf',
            null,
            true
        );
    }

    private function tempFilesMatching(string $pattern): array
    {
        return glob(sys_get_temp_dir().DIRECTORY_SEPARATOR.$pattern) ?: [];
    }

    public function test_extract_returns_a_png_of_the_first_page(): void
    {
        $extractor = $this->makeExtractor();

        $result = $extractor->extract($this->fakePdf());

        $this->assertTrue(is_file($result->getRealPath()));
        $this->assertSame('image/png', $result->getMimeType());
        $this->assertSame('blank_page-page-1.png', $result->getClientOriginalName());

        @unlink($result->getRealPath());
    }

    public function test_extract_does_not_leak_the_raw_tempnam_file(): void
    {
        $before = $this->tempFilesMatching('pdf-page-1-*');

        $result = $extractor = $this->makeExtractor()->extract($this->fakePdf());

        $rawTempFilesLeftBehind = array_diff(
            $this->tempFilesMatching('pdf-page-1-*'),
            $before,
            [$result->getRealPath()]
        );

        $this->assertSame([], $rawTempFilesLeftBehind, 'The tempnam() placeholder file should be removed once the PNG is written.');

        @unlink($result->getRealPath());
    }

    public function test_extract_schedules_the_output_png_for_cleanup_after_the_app_terminates(): void
    {
        $result = $this->makeExtractor()->extract($this->fakePdf());
        $outputPath = $result->getRealPath();

        $this->assertTrue(is_file($outputPath));

        $this->app->terminate();

        $this->assertFalse(is_file($outputPath), 'The extracted PNG should be deleted once the request has terminated.');
    }
}
