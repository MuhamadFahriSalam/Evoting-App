<?php

namespace App\Services;

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

class QrCodeService
{
    public function generate(
        string $data,
        string $filename
    ): string {

        $qrCode = new QrCode(
            data: $data,
            size: 300,
            margin: 10
        );

        $writer = new PngWriter();

        $result = $writer->write($qrCode);

        $directory = storage_path(
            'app/public/qrcodes'
        );

        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        $path = $directory.'/'.$filename.'.png';

        $result->saveToFile($path);

        return $path;
    }
}