<?php
namespace App\Http\Transformers\Constants;

use App\Http\Transformers\BaseTransformer;
use League\Fractal;

class ConstantTransformer extends BaseTransformer
{
    public function transform($constant)
    {
        return [
            'id'   => data_get($constant, "id"),
            'name' => data_get($constant, "name")
        ];
    }
}
