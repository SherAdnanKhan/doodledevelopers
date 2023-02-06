<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use SoftDeletes;
    use Notifiable;

    /**
     * @OA\Schema(
     *     schema="User",
     *     @OA\Property(
     *         property="id",
     *         type="integer",
     *         example=1
     *     ),
     *     @OA\Property(
     *         property="first_name",
     *         type="string",
     *         example="John"
     *     ),
     *     @OA\Property(
     *         property="last_name",
     *         type="string",
     *         example="Doe"
     *     ),
     *     @OA\Property(
     *         property="username",
     *         type="string",
     *         example="johndoe"
     *     ),
     *     @OA\Property(
     *         property="email",
     *         type="string",
     *         format="email",
     *         example="johndoe@gmail.com"
     *     ),
     *     @OA\Property(
     *         property="phone",
     *         type="string",
     *         example="(123)456-7890"
     *     ),
     *     @OA\Property(
     *         property="address",
     *         type="string",
     *         example="130 Botley Road"
     *     ),
     *     @OA\Property(
     *         property="address2",
     *         type="string",
     *         example="Shore Street"
     *     ),
     *     @OA\Property(
     *         property="address3",
     *         type="string",
     *         example="Pier Road"
     *     ),
     *     @OA\Property(
     *         property="county",
     *         type="string",
     *         example="Bristol"
     *     ),
     *     @OA\Property(
     *         property="postcode",
     *         type="string",
     *         example="BS"
     *     ),
     *     @OA\Property(
     *         property="is_kyc_verified",
     *         type="integer",
     *         example="1"
     *     ),
     *     @OA\Property(
     *         property="is_viewed",
     *         type="integer",
     *         example="1"
     *     ),
     *     @OA\Property(
     *         property="is_admin",
     *         type="integer",
     *         example="1"
     *     ),
     *     @OA\Property(
     *         property="dob",
     *         type="date",
     *         example="2000-01-02"
     *     ),
     *     @OA\Property(
     *         property="profile_image",
     *         type="string",
     *         example="http://domain.com/storage/users/profile/d4735e3a265e16eee03f59718b9b5d03019c07d8b6c51f90da3a666ddc13ab35/5f75db467852f.pdf"
     *     ),
     *     @OA\Property(
     *         property="created_at",
     *         type="string",
     *         format="date-time",
     *         example="2020-10-21T09:33:59.000000Z"
     *     ),
     *     @OA\Property(
     *         property="updated_at",
     *         type="string",
     *         format="date-time",
     *         example="22020-10-21T09:33:59.000000Z"
     *     ),
     *     @OA\Property(
     *         property="status",
     *         @OA\Property(
     *             property="id",
     *             type="string",
     *             example="active"
     *         ),
     *         @OA\Property(
     *             property="name",
     *             type="string",
     *             example="Active"
     *         )
     *     ),
     *     @OA\Property(
     *         property="country",
     *         allOf={
     *             @OA\Schema(ref="#/components/schemas/Country")
     *         }
     *     )
     * )
     */

    /**
     * @OA\Schema(
     *     schema="UserAdmin",
     *     @OA\Property(
     *         property="id",
     *         type="integer",
     *         example=1
     *     ),
     *     @OA\Property(
     *         property="first_name",
     *         type="string",
     *         example="John"
     *     ),
     *     @OA\Property(
     *         property="last_name",
     *         type="string",
     *         example="Doe"
     *     ),
     *     @OA\Property(
     *         property="username",
     *         type="string",
     *         example="johndoe"
     *     ),
     *     @OA\Property(
     *         property="email",
     *         type="string",
     *         format="email",
     *         example="johndoe@gmail.com"
     *     ),
     *     @OA\Property(
     *         property="phone",
     *         type="string",
     *         example="(123)456-7890"
     *     ),
     *     @OA\Property(
     *         property="address",
     *         type="string",
     *         example="130 Botley Road"
     *     ),
     *     @OA\Property(
     *         property="address2",
     *         type="string",
     *         example="Shore Street"
     *     ),
     *     @OA\Property(
     *         property="address3",
     *         type="string",
     *         example="Pier Road"
     *     ),
     *     @OA\Property(
     *         property="county",
     *         type="string",
     *         example="Bristol"
     *     ),
     *     @OA\Property(
     *         property="postcode",
     *         type="string",
     *         example="BS"
     *     ),
     *     @OA\Property(
     *         property="city",
     *         type="string",
     *         example="Bristol"
     *     ),
     *     @OA\Property(
     *         property="is_viewed",
     *         type="boolean",
     *         example="0"
     *     ),
     *     @OA\Property(
     *         property="profile_image",
     *         type="string",
     *         example="http://domain.com/storage/users/profile/d4735e3a265e16eee03f59718b9b5d03019c07d8b6c51f90da3a666ddc13ab35/5f75db467852f.pdf"
     *     ),
     *     @OA\Property(
     *         property="status",
     *         @OA\Property(
     *             property="id",
     *             type="string",
     *             example="active"
     *         ),
     *         @OA\Property(
     *             property="name",
     *             type="string",
     *             example="Active"
     *         )
     *     ),
     *     @OA\Property(
     *         property="country",
     *         allOf={
     *             @OA\Schema(ref="#/components/schemas/Country")
     *         }
     *     ),
     *     @OA\Property(
     *         property="hearaboutusplatform",
     *         allOf={
     *             @OA\Schema(ref="#/components/schemas/HearAboutUsPlatform")
     *         }
     *     )
     * )
     */

    protected $guarded = ['created_at', 'updated_at', 'deleted_at'];

    const USER_STATUS_NEW = 'new';
    const USER_STATUS_ACTIVE = 'active';
    const USER_STATUS_DISABLED = 'disabled';


    public function scopeOfStatus($query, $status) {
        return $query->where('status', $status);
    }

    public function scopeIsAdmin($query) {
        return $query->where('is_admin', 0);
    }

    /**
     * @return BelongsTo
     */
    public function country() : BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }

    /**
     * @return HasOne
     */
    public function kycValidation() : HasOne
    {
        return $this->hasOne(KycValidation::class, 'user_id');
    }

    /**
     * @return HasMany
     */
    public function wallets() : HasMany
    {
        return $this->hasMany(UserWallet::class, 'user_id');
    }

    /**
     * @return BelongsToMany
     */
    public function games() : BelongsToMany
    {
        return $this->belongsToMany(Game::class , 'game_players', 'user_id', 'game_id')
            ->withPivot('id', 'number_of_times_played', 'highest_score', 'shortest_duration', 'status', 'token')
            ->withTimestamps();
    }

    /**
     * @return BelongsToMany
     */
    public function scores() : BelongsToMany
    {
        return $this->belongsToMany(Game::class , 'game_player_scores', 'user_id', 'game_id')
            ->withPivot('id', 'score', 'duration')
            ->withTimestamps();
    }

    /**
     * @return BelongsToMany
     */
    public function attemptScores() : BelongsToMany
    {
        return $this->belongsToMany(Game::class , 'game_player_attempt_scores', 'user_id', 'game_id')
            ->withPivot('id', 'attempt_number', 'score', 'duration')
            ->withTimestamps();
    }

    /**
     * @return BelongsToMany
     */
    public function earnings() : BelongsToMany
    {
        return $this->belongsToMany(Game::class, 'game_winner_earnings', 'user_id', 'game_id')
            ->withPivot('id', 'earning' , 'status')
            ->withTimestamps();
    }

    /**
     * @return hasMany
     */
    public function winnerEarnings() : hasMany
    {
        return $this->hasMany(GameWinnerEarnings::class, 'user_id');
    }

    /**
     * @return HasMany
     */
    public function deposits() : HasMany
    {
        return $this->hasMany(Deposit::class, 'user_id');
    }

    /**
     * @return HasMany
     */
    public function withdrawals() : HasMany
    {
        return $this->hasMany(Withdrawal::class, 'user_id');
    }

    /**
     * @return HasMany
     */
    public function userTransactions() : HasMany
    {
        return $this->hasMany(UserTransaction::class, 'user_id');
    }

    /**
     * @return HasMany
     */
    public function gameTransactions() : HasMany
    {
        return $this->hasMany(GameTransaction::class, 'user_id');
    }

    /**
     * @return string[]
     */
    public static function statuses() : array
    {
        return [
            static::USER_STATUS_NEW => "New",
            static::USER_STATUS_ACTIVE => "Active",
            static::USER_STATUS_DISABLED => "Disabled"
        ];
    }

    /**
     * @return bool
     */
    public function isPlayingGame() : bool
    {
        foreach ($this->games as $game) {
            if ($game->pivot->where('status', GamePlayer::STATUS_PLAYING)->where('user_id', $this->id)->count() > 0) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param int $gameID
     * @return bool
     */
    public function isPlayingGameByGameID(int $gameID) : bool
    {
        if ($this->games()->where('game_id', $gameID)->wherePivot('status', GamePlayer::STATUS_PLAYING)->count() > 0)
        {
            return true;
        }
        foreach ($this->games as $game) {
            if ($game->pivot->where('status', GamePlayer::STATUS_PLAYING)->where('user_id', $this->id)->count() > 0) {
                return true;
            }
        }

        return false;
    }

    public function resolveChildRouteBinding($childType, $value, $field)
    {
        // TODO: Implement resolveChildRouteBinding() method.
    }

    /**
     * @return HasOne
     */
    public function earning() : HasOne
    {
        return $this->hasOne(GameWinnerEarnings::class, 'user_id');
    }

    /**
     * @return HasMany
     */
    public function invitations() : HasMany
    {
        return $this->hasMany(UserInvitation::class, 'sender_user_id');
    }

    /**
     * @return HasMany
     */
    public function gameWallets() : HasMany
    {
        return $this->hasMany(UserGameWallet::class, 'user_id');
    }

    /**
     * @return HasMany
     */
    public function tickets() : HasMany
    {
        return $this->hasMany(SupportTicket::class, 'user_id');
    }

    /**
     * @return BelongsTo
     */
    public function hearAboutUsPlatform() : BelongsTo
    {
        return $this->belongsTo(HearAboutUsPlatform::class, 'hear_about_us_platform_id', 'id');
    }
}
