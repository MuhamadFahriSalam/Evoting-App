<?php

namespace App\Services;

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;

class QrCodeService
{
    public function generate(string $token, string $filename)
    {
        $result = Builder::create()
            ->writer(new PngWriter())
            ->data($token)
            ->size(300)
            ->margin(10)
            ->build();

        $path = storage_path(
            'app/public/qrcodes/'.$filename.'.png'
        );

        $result->saveToFile($path);

        return $path;
    }
}