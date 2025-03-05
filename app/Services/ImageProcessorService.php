<?php

namespace App\Services;

use Spatie\Image\Drivers\Gd\GdDriver;
use Spatie\Image\Drivers\ImageDriver;
use Spatie\Image\Image;


Class ImageProcessorService extends Image
{
    protected ImageDriver $imageDriver;
    public function __construct(?string $pathToImage = null)
    {
        $this->imageDriver = new GdDriver;

        if ($pathToImage) {
            $this->imageDriver->loadFile($pathToImage);
        }
    }
}
