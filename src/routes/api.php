<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*
 * AUTH ROUTES
 */
Route::prefix('auth')->group(function () {
    Route::post('register', 'Users\AuthController@register');
    Route::post('login', 'Users\AuthController@login');
    Route::get('signup/activate/{token}', 'Users\AuthController@userActivate')->name('token-activation');
    Route::get('logout', 'Users\AuthController@logout')->middleware('auth:api');
    Route::prefix('forget-password')->group(function(){
        Route::post('', 'Users\AuthController@forget');
        Route::get('{token}', 'Users\AuthController@reset');
        Route::post('confirm', 'Users\AuthController@confirm');
    });
});

Route::get('constants', 'Constants\ConstantsController@index');
Route::get('games', 'Games\GameController@getLiveGames');
Route::get('games-winners', 'Games\GameController@getGamesWinners');

Route::group(['middleware' => ['auth:api']], function () {
    Route::get('user', 'Users\UserController@index');
});
/*
 * USER ROUTES
 */

Route::group(['middleware' => ['auth:api', 'is_user']], function () {
    Route::prefix('users')->group(function(){

        Route::prefix('kyc-validations/{kycValidation}')->group(function () {
            Route::resource('documents', 'KycValidations\KycValidationDocumentController')->except(['index', 'create', 'edit']);
        });
        Route::resource('kyc-validations', 'KycValidations\KycValidationController')->except(['create', 'edit', 'update']);

        Route::prefix('games/{game}')->group(function () {
            Route::get('scoreboard', 'Games\GamePlayerController@scoreboard');
            Route::post('play', 'Games\GamePlayerController@playGame');
            Route::get('check-expiry', 'Games\GamePlayerController@checkExpiry');
            Route::resource('scores', 'Games\GamePlayerScoreController')->only(['index']);
            Route::get('invitation-link', 'Games\GamePlayerController@invitationLink');
            Route::resource('payouts', 'Payouts\PayoutController')->except(['create', 'edit', 'update', 'destroy' , 'show']);
        });
        Route::prefix('games')->group(function () {
            Route::resource('history', 'Games\GameHistoryController')->only(['index']);
        });
        Route::resource('games', 'Games\GameController')->except(['create', 'edit']);
        Route::prefix('deposits')->group(function() {
            Route::post('process', 'Payments\Red6six\DepositController@processDeposit');
        });
        Route::resource('deposits', 'Payments\Red6six\DepositController')->except(['create', 'edit']);
//        Route::resource('withdrawals', 'Payments\Red6six\WithdrawalController')->except(['create', 'edit']);
        Route::resource('user-transactions', 'Payments\Red6six\UserTransactionController')->except(['create', 'edit']);
        Route::prefix('wallets/{wallet}')->group(function () {
            Route::resource('transactions', 'Wallets\WalletTransactionController')->except(['create', 'edit']);
            Route::resource('game-transactions', 'Wallets\GameTransactionController')->except(['create', 'edit']);
        });

        Route::resource('wallets', 'Wallets\WalletController')->except(['create', 'edit']);
        Route::resource('game-wallets', 'Wallets\GameWalletController')->only('index', 'show');
        Route::resource('tickets', 'TicketSupport\TicketController')->except(['create', 'edit']);
        Route::post('ticket-message', 'TicketSupport\TicketMessageController@message');

        Route::resource('hear-about-us-platforms', 'HearAboutUs\HearAboutUsPlatformController')->only('index');
    });
    Route::prefix('users/{user}')->group(function () {
        Route::put('update-password', 'Users\UserController@updatePassword');
    });
    Route::resource('users', 'Users\UserController')->only(['update']);
});

/*
 * ADMIN ROUTES
 */
Route::group(['middleware' => ['auth:api', 'is_admin']], function () {
    Route::prefix('admin')->group(function () {
        Route::resource('hear-about-us-platforms', 'HearAboutUs\HearAboutUsPlatformAdminController');
        Route::get('hear-about-us-platform-count', 'HearAboutUs\HearAboutUsPlatformAdminController@hearAboutUsPlatformCount');
        Route::resource('kyc-validations', 'KycValidations\KycValidationAdminController')->except(['create', 'edit', 'store']);
        Route::prefix('games/{game}')->group(function () {
            Route::resource('players', 'Games\GamePlayerAdminController')->except(['create', 'edit', 'store', 'update']);
            Route::resource('payouts', 'Payouts\PayoutAdminController')->except(['create', 'edit', 'store', 'destroy' , 'show']);
        });
        Route::resource('earnings', 'Games\GameEarningAdminController')->only(['index', 'show']);
        Route::get('earning', 'Games\GameEarningAdminController@getEarning');
        Route::resource('games', 'Games\GameAdminController')->except(['create', 'edit']);
        Route::resource('configurations', 'Games\GameConfigurationAdminController')->except(['create', 'edit', 'show']);
        Route::post('stop-games', 'Games\GameAdminController@stopGame');
        Route::resource('deposits', 'Payments\Red6six\DepositAdminController')->only(['index']);
        Route::resource('tickets', 'TicketSupport\TicketAdminController')->except(['create', 'edit', 'delete']);
        Route::resource('users', 'Users\UserAdminController')->except(['create']);
        Route::put('disable-user-account', 'Users\UserAdminController@disableUser');
        Route::resource('maps', 'Maps\MapAdminController')->except(['create', 'show']);
    });
});

/*
 * GAME SERVER ROUTES
 */

Route::group(['middleware' => ['api', 'client_credentials', 'is_game_server']], function(){
    Route::prefix('game-server')->group(function(){
        Route::get('game-map', 'Games\GameServerController@getGameMap');
        Route::post('add-score', 'Games\GameServerController@addAttemptScore');
        Route::get('game-player-state', 'Games\GameServerController@getGamePlayerState');
        Route::post('game-player-state', 'Games\GameServerController@addGamePlayerState');
    });

});
