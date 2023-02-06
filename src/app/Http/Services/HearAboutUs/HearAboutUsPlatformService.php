<?php
namespace App\Http\Services\HearAboutUs;

use App\Exceptions\ErrorException;
use App\Models\HearAboutUs;
use App\Models\HearAboutUsPlatform;
use App\Http\Services\BaseService;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class HearAboutUsPlatformService extends BaseService
{
    /**
     * @return LengthAwarePaginator
     */
    public function getAll() : LengthAwarePaginator
    {
        return HearAboutUsPlatform::paginate(10);
    }

    /**
     * @param array $data
     * @return HearAboutUsPlatform
     */
    public function store(array $data) : HearAboutUsPlatform
    {
        Log::info(__METHOD__ . " -- Admin create new hear about us platform:", $data);
        return HearAboutUsPlatform::create($data);
    }

    /**
     * @param HearAboutUsPlatform $hearAboutUsPlatform
     * @param array $data
     * @return bool
     */
    public function update(HearAboutUsPlatform $hearAboutUsPlatform, array $data) : bool
    {
        Log::info(__METHOD__ . " -- Admin update hear about us platform:", $data);
        return $hearAboutUsPlatform->update($data);
    }

    /**
     * @param HearAboutUsPlatform $hearAboutUsPlatform
     * @return bool
     * @throws ErrorException
     */
    public function delete(HearAboutUsPlatform $hearAboutUsPlatform) : bool
    {
        Log::alert(__METHOD__ . " -- Admin delete the hear about us platform", $hearAboutUsPlatform->toArray());
        if ($hearAboutUsPlatform->user()->count()) {
            Log::error(__METHOD__ . " -- Unable to delete platform, User exists against this platform", $hearAboutUsPlatform->toArray());
            throw new ErrorException('exception.cannot_delete_record', [], 500);
        }

        return $hearAboutUsPlatform->delete();
    }


    /**
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function hearAboutUsCount() : \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return User::with('hearAboutUsPlatform')
                ->select('hear_about_us_platform_id', DB::raw('count(*) as total'))
                ->where('hear_about_us_platform_id', '!=', 'null')
                ->groupBy('hear_about_us_platform_id')->paginate(10);
    }
}
