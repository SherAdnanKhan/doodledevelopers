<?php

namespace App\Http\Transformers\Constants;

use App\Http\Transformers\BaseTransformer;
use League\Fractal;

class CurrencyTransformer extends BaseTransformer
{
    public function transform($currency)
    {
        return [
            'id'   => $currency->id,
            'name' => $currency->name,
            'label' => $currency->label
        ];
    }
}
