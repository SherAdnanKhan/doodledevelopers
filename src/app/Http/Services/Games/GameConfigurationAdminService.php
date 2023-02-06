<?php

namespace App\Http\Services\Games;

use App\Http\Services\BaseService;
use App\Models\GameConfiguration;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

class GameConfigurationAdminService extends BaseService
{
    /**
     * @return LengthAwarePaginator
     */
    public function getAll() : LengthAwarePaginator
    {
        return GameConfiguration::paginate(10);
    }

    /**
     * @param array $data
     * @return GameConfiguration
     */
    public function store(array $data) : GameConfiguration
    {
        Log::info(__METHOD__ . " -- Admin create configuration", $data);
        return GameConfiguration::create($data);
    }

    /**
     * @param GameConfiguration $configuration
     * @param array $data
     * @return bool
     */
    public function update(GameConfiguration $configuration, array $data) : bool
    {
        Log::info(__METHOD__ . " -- Admin update the configuration", $data);

        return $configuration->update($data);
    }

    /**
     * @param GameConfiguration $configuration
     * @return bool
     * @throws \Exception
     */
    public function destroy(GameConfiguration $configuration) : bool
    {
        Log::alert(__METHOD__ . " -- Admin delete the configuration");
        return $configuration->delete();
    }

}
