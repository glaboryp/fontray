<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
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

        $manager = new ImageManager(new Driver);
        $image = $manager->read($pdf->getRealPath().'[0]');
        $image->toPng()->save($outputPath);

        return new UploadedFile(
            $outputPath,
            pathinfo($pdf->getClientOriginalName(), PATHINFO_FILENAME).'-page-1.png',
            'image/png',
            null,
            true
        );
    }
}
