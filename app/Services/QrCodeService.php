<?php

namespace App\Services;

use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Renderer\Image\RendererStyle\Fill;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Writer;

class QrCodeService
{
    public function generateQrCode($packageName, $packageDuration, $size = 300)
    {
        $data = json_encode([
            'package_name' => $packageName,
            'package_duration' => $packageDuration
        ]);

        $renderer = new ImageRenderer(
            new RendererStyle($size),
            new SvgImageBackEnd()
        );

        $writer = new Writer($renderer);
        return $writer->writeString($data);
    }
}

