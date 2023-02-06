<?php
namespace App\Http\Transformers\HearAboutUs;

use App\Http\Transformers\BaseTransformer;
use App\Models\HearAboutUsPlatform;
use League\Fractal;

class HearAboutUsPlatformTransformer extends BaseTransformer
{
    public function transform(HearAboutUsPlatform $hearAboutUsPlatform)
    {
        return [
            'id' => $hearAboutUsPlatform->id,
            'name' => $hearAboutUsPlatform->name,
            'label' => $hearAboutUsPlatform->label
        ];
    }
}
