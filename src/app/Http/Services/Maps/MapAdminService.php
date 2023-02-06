<?php

namespace App\Http\Services\Maps;

use App\Http\Services\BaseService;
use App\Models\Map;
use Illuminate\Pagination\LengthAwarePaginator;

class MapAdminService extends BaseService
{
    /**
     * @return LengthAwarePaginator
     */
    public function getAll() : LengthAwarePaginator
    {
        return Map::paginate(10);
    }
}
