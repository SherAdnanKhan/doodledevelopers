<?php

namespace App\Repositories\Compressions\Images;

use Intervention\Image\Facades\Image;

class SpatieImageRepository implements ImageRepositoryInterface
{
    /**
     * Resize image
     * @param array $data
     * @return \Intervention\Image\Image
     */
    public function resize(array $data) : \Intervention\Image\Image
    {
        return Image::make($data['imagePath'])
            ->resize($data['width'], $data['height'], function ($constraint) {
                $constraint->aspectRatio();
            })
            ->save($data['imagePath']);
    }

    /**
     * Optimize image
     * @param array $data
     * @return \Intervention\Image\Image
     */
    public function optimize(array $data): \Intervention\Image\Image
    {
        return Image::make($data['imagePath'])
            ->save($data['imagePath'], $data['quality'] ?? 100);
    }
}
