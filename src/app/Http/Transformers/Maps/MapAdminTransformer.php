<?php

namespace App\Http\Transformers\Maps;

use App\Http\Transformers\BaseTransformer;
use App\Models\Map;

class MapAdminTransformer extends BaseTransformer
{
    public function transform(Map $map)
    {
        return [
            'id' => $map->id,
            'data' => $map->data
        ];
    }

}

