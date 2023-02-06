<?php
namespace App\Http\Transformers\Users;

use App\Http\Transformers\BaseTransformer;
use App\Http\Transformers\Constants\ConstantTransformer;
use App\Http\Transformers\Games\GamePlayerTransformer;
use App\Http\Transformers\Games\GameUserAdminTransformer;
use App\Http\Transformers\Games\GameWinnerEarningTransformer;
use App\Http\Transformers\Payments\Red6six\DepositTransformer;
use App\Http\Transformers\Wallets\GameWalletTransformer;
use App\Http\Transformers\Wallets\WalletTransformer;
use App\Models\Country;
use App\Models\User;
use League\Fractal;

class UserAdminTransformer extends BaseTransformer
{
    protected $defaultIncludes = [
        'country', 'status'
    ];

    protected $availableIncludes = [
        'deposits', 'games', 'wallet', 'gamewallets', 'earnings'
    ];

    public function transform(User $user)
    {
        return [
            'id' => $user->id,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'username' => $user->username,
            'email' => $user->email,
            'phone' => $user->phone,
            'address' => $user->address,
            'address2' => $user->address2,
            'address3' => $user->address3,
            'county' => $user->county,
            'postcode' => $user->postcode,
            'city' => $user->city,
            'is_kyc_verified' => $user->is_kyc_verified,
            'is_viewed' => $user->is_viewed,
            'is_admin' => $user->is_admin,
            'dob' => $user->dob,
            'profile_image' => (isset($user->profile_image) && !empty($user->profile_image)) ? asset("storage/$user->profile_image") : null,
            'created_at' => $user->created_at,
            'updated_at' => $user->updated_at
        ];
    }

    public function includeStatus(User $user)
    {
        $item = [
            'id' => $user->status,
            'name' => data_get(User::statuses(), $user->status)
        ];

        return $this->item($item, new ConstantTransformer);
    }

    public function includeCountry(User $user)
    {
        $item = [
            'id' => $user->country->id,
            'name' => $user->country->label
        ];

        return $this->item($item, new ConstantTransformer);
    }

    public function includeDeposits(User $user)
    {
        return $this->collection($user->deposits, new DepositTransformer);
    }

    public function includeGames(User $user)
    {
        return $this->collection($user->games, new GameUserAdminTransformer);
    }

    public function includeWallet(User $user)
    {
        return $this->item($user->wallets->first(), new WalletTransformer);
    }

    public function includeGamewallets(User $user)
    {
        return $this->collection($user->gameWallets, new GameWalletTransformer);
    }

    public function includeEarnings(User $user)
    {
        return $this->collection($user->winnerEarnings, new GameWinnerEarningTransformer);
    }

}
