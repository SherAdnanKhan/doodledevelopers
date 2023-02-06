<?php
namespace App\Http\Services\Users;

use App\Exceptions\ErrorException;
use App\Http\Services\BaseService;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

class UserAdminService extends BaseService
{
    /**
     * @param array $data
     * @return LengthAwarePaginator
     */
    public function getAll(array $data) : LengthAwarePaginator
    {
        $user = new User();

        if (isset($data['status'])) {
            $user = $user->ofStatus($data['status']);
        }

        return $user->isAdmin()->paginate(10);
    }

    /**
     * @param User $user
     * @param array $data
     * @return bool
     */
    public function update(User $user, array $data) : bool
    {
        Log::info(__METHOD__ . " -- user: -- " . $user->email . " -- Update user by admin", $data);

        return $user->update($data);
    }

    /**
     * @param array $data
     * @return User
     * @throws ErrorException
     */
    public function disableUser(array $data) : User
    {
        $user = User::where('id', $data['user_id'])->first();

        if ($user->status == User::USER_STATUS_DISABLED) {
            throw new ErrorException('exception.user_already_disabled');
        }

        $user->update(['status' => User::USER_STATUS_DISABLED]);

        Log::info(__METHOD__ . " -- user: -- " . $user->email . " -- Disabled by admin");

        return $user;
    }
}
