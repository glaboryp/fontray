<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Imagick;
use Intervention\Image\Drivers\Imagick\Driver;
use Intervention\Image\ImageManager;

class PdfFirstPageImageExtractor
{
    public function extract(UploadedFile $pdf): UploadedFile
    {
        $tempPath = tempnam(sys_get_temp_dir(), 'pdf-page-1-');

        if ($tempPath === false) {
            throw new \RuntimeException('No se pudo preparar el archivo temporal para el PDF.');
        }

        $outputPath = $tempPath.'.png';

        try {
            // Imagick's own page-selector syntax ("path[0]") must be resolved by
            // Imagick itself: Intervention's file-path decoder rejects it outright
            // because is_file('path[0]') is always false, so we decode the first
            // page via Imagick directly and hand the resulting object to Intervention.
            $firstPage = new Imagick;
            $firstPage->readImage($pdf->getRealPath().'[0]');

            $manager = new ImageManager(new Driver);
            $image = $manager->read($firstPage);
            $image->toPng()->save($outputPath);
        } finally {
            @unlink($tempPath);
        }

        app()->terminating(function () use ($outputPath) {
            if (is_file($outputPath)) {
                @unlink($outputPath);
            }
        });

        return new UploadedFile(
            $outputPath,
            pathinfo($pdf->getClientOriginalName(), PATHINFO_FILENAME).'-page-1.png',
            'image/png',
            null,
            true
        );
    }
}
