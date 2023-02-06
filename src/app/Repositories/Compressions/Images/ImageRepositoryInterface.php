<?php

namespace App\Repositories\Compressions\Images;

use Intervention\Image\Image;

/**
 * Interface ImageRepositoryInterface
 * @package App\Repositories\Compressions\Images
 */
interface ImageRepositoryInterface
{
    /**
     * Resize image
     * @param array $data
     * @return Image
     */
    public function resize(array $data): Image;

    /**
     * Optimize image
     * @param array $data
     * @return Image
     */
    public function optimize(array $data): Image;
}
