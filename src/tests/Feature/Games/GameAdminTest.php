<?php
namespace Tests\Feature\Games;

use App\Models\Game;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Artisan;
use Tests\BaseTestCase;

class GameAdminTest extends BaseTestCase
{
    private function createGame(array $data, $adminHeaders)
    {
        $response = $this
            ->withHeaders($adminHeaders)
            ->post('/api/admin/games', $data);

        return json_decode($response->getContent(), true);
    }

    private function getTodayDate()
    {
        $date = Carbon::now();
        return $date->format('Y-m-d');
    }

    private function getTomorrowDate()
    {
        $date = Carbon::now();
        return $date->addDays(4)->format('Y-m-d');
    }

    /**
     * @test
     */
    public function testAddNewGameSuccess()
    {
       $adminHeaders = $this->registerAndLoginAdmin();

       $data = [
            "jackpot_value" => 10000,
            "admin_fee_percentage" => 30,
            "entry_fee" => 100,
            "game_ext_days" => 3,
            "start_date" => $this->getTodayDate(),
            "end_date" => $this->getTomorrowDate(),
       ];

       $content = $this->createGame($data, $adminHeaders);

       $this->assertEquals('Game created successfully', $content['message']);
    }

    /**
     * @test
     */
    public function testUpdateGameSuccess()
    {
        $adminHeaders = $this->registerAndLoginAdmin();

        $data = [
            "jackpot_value" => 10000,
            "admin_fee_percentage" => 30,
            "entry_fee" => 100,
            "game_ext_days" => 3,
            "start_date" => $this->getTodayDate(),
            "end_date" => $this->getTomorrowDate(),
        ];

        $content = $this->createGame($data, $adminHeaders);
        $gameId = $content['data']['id'];

        $updateData = [
            "status" => "live",
            "admin_fee_percentage" => 40,
            "game_ext_days" => 4,
            "start_date" => "2020-10-14",
            "end_date" => "2020-10-16",
        ];

        $response = $this
            ->withHeaders($adminHeaders)
            ->put("/api/admin/games/{$gameId}", $updateData);
        $response->assertStatus(200);

        $content = json_decode($response->getContent(), true);

        $this->assertEquals('Game updated successfully', $content['message']);
        $this->assertEquals($gameId, $content['data']['id']);
    }

    /**
     * @test
     */
    public function testUpdateGameError()
    {
        $adminHeaders = $this->registerAndLoginAdmin();

        $data = [
            "jackpot_value" => 10000,
            "admin_fee_percentage" => 30,
            "entry_fee" => 100,
            "game_ext_days" => 3,
            "start_date" => $this->getTodayDate(),
            "end_date" => $this->getTomorrowDate(),
        ];

        $content = $this->createGame($data, $adminHeaders);
        $gameId = $content['data']['id'];

        $updateData = [
            "status" => "live",
            "admin_fee_percentage" => 40,
            "game_ext_days" => 4,
            "entry_fee" => 200,
            "start_date" => $this->getTodayDate(),
            "end_date" => $this->getTomorrowDate(),
        ];

        $response = $this
            ->withHeaders($adminHeaders)
            ->put("/api/admin/games/{$gameId}", $updateData);
        $response->assertStatus(422);

        $content = json_decode($response->getContent(), true);

        $this->assertEquals('Validation Error', $content['errors']['message']);
        $this->assertEquals('The number of winners field is required when entry fee is present.', $content['errors']['errors']['number_of_winners'][0]);
    }

    /**
     * @test
     */
    public function testGetGameById()
    {
        $adminHeaders = $this->registerAndLoginAdmin();

        $data = [
            "jackpot_value" => 10000,
            "admin_fee_percentage" => 30,
            "entry_fee" => 100,
            "game_ext_days" => 3,
            "start_date" => $this->getTodayDate(),
            "end_date" => $this->getTomorrowDate(),
        ];

        $content = $this->createGame($data, $adminHeaders);
        $gameId = $content['data']['id'];

        $response = $this
            ->withHeaders($adminHeaders)
            ->get("/api/admin/games/{$gameId}");
        $response->assertStatus(200);

        $content = json_decode($response->getContent(), true);

        $this->assertEquals("Success", $content['message']);
        $this->assertEquals($gameId, $content['data']['id']);
    }

    /**
     * @test
     */
    public function testGetGamePlayers()
    {
        $adminHeaders = $this->registerAndLoginAdmin();

        $data = [
            "jackpot_value" => 5000,
            "admin_fee_percentage" => 30,
            "entry_fee" => 100,
            "game_ext_days" => 3,
            "start_date" => $this->getTodayDate(),
            "end_date" => $this->getTomorrowDate(),
        ];

        $content = $this->createGame($data, $adminHeaders);
        $gameId = $content['data']['id'];

        $updateData = [
            "status" => "live"
        ];

        $response = $this
            ->withHeaders($adminHeaders)
            ->put("/api/admin/games/{$gameId}", $updateData);
        $response->assertStatus(200);

        $userHeaders = $this->registerAndLoginUser();

        $this
            ->withHeaders($userHeaders)
            ->post("/api/users/games/{$gameId}/play");

        $response = $this
            ->withHeaders($userHeaders)
            ->get("/api/admin/games/{$gameId}/players");
        $response->assertStatus(200);
        $content = json_decode($response->getContent(), true);

        $this->assertEquals('Success',  $content['message']);
    }

    /**
     * @test
     */
    public function testExtendGameDaysSuccess()
    {
        $adminHeaders = $this->registerAndLoginAdmin();

        $data = [
            "jackpot_value" => 5000,
            "admin_fee_percentage" => 30,
            "entry_fee" => 100,
            "game_ext_days" => 3,
            "start_date" => $this->getTodayDate(),
            "end_date" => $this->getTodayDate(),
        ];

        $content = $this->createGame($data, $adminHeaders);
        $gameId = $content['data']['id'];

        $updateData = [
            "status" => "live"
        ];

        $response = $this
            ->withHeaders($adminHeaders)
            ->put("/api/admin/games/{$gameId}", $updateData);
        $response->assertStatus(200);

        Artisan::call('game:extend');

        $gameWithExtensions = Game::with('extensions')->where('id', $gameId)->first()->toArray();

        $endDate = \Carbon\Carbon::parse($gameWithExtensions['end_date']);
        $startDate = \Carbon\Carbon::parse($gameWithExtensions['start_date']);

        $diffInDays = $endDate->diffInDays($startDate);

        $this->assertEquals('1', $gameWithExtensions['is_extended']);
        $this->assertEquals($gameWithExtensions['game_ext_days'], $diffInDays);
    }

    /**
     * @test
     */
    public function testMaxGameExtensionCompleted()
    {
        $adminHeaders = $this->registerAndLoginAdmin();

        $data = [
            "jackpot_value" => 5000,
            "admin_fee_percentage" => 30,
            "entry_fee" => 100,
            "game_ext_days" => 0,
            "start_date" => "2020-10-14",
            "end_date" => "2020-10-14",
        ];

        $content = $this->createGame($data, $adminHeaders);
        $gameId = $content['data']['id'];

        $updateData = [
            "status" => "live",
            "pot_value" => 1500,
        ];

        $response = $this
            ->withHeaders($adminHeaders)
            ->put("/api/admin/games/{$gameId}", $updateData);
        $response->assertStatus(200);

        Artisan::call('game:extend');
        Artisan::call('game:extend');
        Artisan::call('game:extend');
        Artisan::call('game:extend');
        Artisan::call('game:extend');

        $game = Game::where('id', $gameId)->first();

        $gameExtensionsCount = $game->getExtensionsCountAttribute();

        $this->assertNotEquals(5, $gameExtensionsCount);

    }

    /**
     * @test
     */
    //    public function testGetGamePlayer()
    //    {
    //        //ToDo Incomplete issue in game player transformer
    //
    //        $adminHeaders = $this->registerAndLoginAdmin();
    //
    //        $data = [
    //            "jackpot_value" => 10000,
    //            "admin_fee_percentage" => 30,
    //            "entry_fee" => 100,
    //            "game_ext_days" => 3,
    //            "start_date" => $this->getTodayDate(),
    //            "end_date" => $this->getTomorrowDate(),
    //        ];
    //
    //        $content = $this->createGame($data, $adminHeaders);
    //        $gameId = $content['data']['id'];
    //
    //        $updateData = [
    //            "status" => "live",
    //            "admin_fee_percentage" => 40,
    //            "number_of_winners" => 30
    //        ];
    //
    //        $response = $this
    //            ->withHeaders($adminHeaders)
    //            ->put("/api/admin/games/{$gameId}", $updateData);
    //        $response->assertStatus(200);
    //
    //        $userHeaders = $this->registerAndLoginUser();
    //
    //        $this
    //            ->withHeaders($userHeaders)
    //            ->post("/api/users/games/{$gameId}/play");
    //
    //        $userHeaders = $this->registerAndLoginUser();
    //
    //        $this
    //            ->withHeaders($userHeaders)
    //            ->post("/api/users/games/{$gameId}/play");
    //
    //        $response = $this
    //            ->withHeaders($userHeaders)
    //            ->get("/api/admin/games/{$gameId}/players");
    //        $response->assertStatus(200);
    //        $players = json_decode($response->getContent(), true);
    //
    //        $playerId = $players['data']['0']['user']['id'];
    //
    //        $response = $this
    //            ->withHeaders($adminHeaders)
    //            ->get("/api/admin/games/{$gameId}/players/{$playerId}");
    //
    //        $gamePlayer = json_decode($response->getContent(), true);
    //
    //        dd($gamePlayer);
    //    }

    //    public function testAddNewGameWithInvalidParams()
    //    {
    //        ToDo when code is modified
    //        ToDo Incomplete
    //        $adminHeaders = $this->registerAndLoginAdmin();
    //
    //        $data = [
    //            "jackpot_value" => -50000,
    //            "admin_fee_percentage" => -30,
    //            "entry_fee" => -100,
    //            "game_ext_days" => -3,
    //            "start_date" => "2020-10-13",
    //            "end_date" => "2020-10-13",
    //        ];
    //
    //        $content = $this->createGame($data, $adminHeaders);
    //
    //        dd($content);
    //    }

    //    public function testGetGamePlayerWithInvalidGameId()
    //    {
    //        //ToDo Incomplete
    //
    //        $adminHeaders = $this->registerAndLoginAdmin();
    //
    //        $data = [
    //            "jackpot_value" => 5000,
    //            "admin_fee_percentage" => 30,
    //            "entry_fee" => 100,
    //            "game_ext_days" => 3,
    //            "start_date" => "2020-10-14",
    //            "end_date" => "2020-10-21",
    //        ];
    //
    //        $content = $this->createGame($data, $adminHeaders);
    //        $gameId = $content['data']['id'];
    //
    //        $updateData = [
    //            "status" => "live"
    //        ];
    //
    //        $response = $this
    //            ->withHeaders($adminHeaders)
    //            ->put("/api/admin/games/{$gameId}", $updateData);
    //        $response->assertStatus(200);
    //
    //        $userHeaders = $this->registerAndLoginUser();
    //
    //        $this
    //            ->withHeaders($userHeaders)
    //            ->post("/api/users/games/{$gameId}/play");
    //
    //        $response = $this
    //            ->withHeaders($userHeaders)
    //            ->get("/api/admin/games/7/players");
    //        //$response->assertStatus(200);
    //        $content = json_decode($response->getContent(), true);
    //        dd($content);
    //        //$this->assertEquals('Success',  $content['message']);
    //    }

    //    public function testDeleteGamePlayer()
    //    {
            //ToDo when code is updated
    //        $adminHeaders = $this->registerAndLoginAdmin();
    //
    //        $data = [
    //            "jackpot_value" => 5000,
    //            "admin_fee_percentage" => 30,
    //            "entry_fee" => 100,
    //            "game_ext_days" => 3,
    //            "start_date" => "2020-10-14",
    //            "end_date" => "2020-10-21",
    //        ];
    //
    //        $content = $this->createGame($data, $adminHeaders);
    //        $gameId = $content['data']['id'];
    //
    //        $updateData = [
    //            "status" => "live"
    //        ];
    //
    //        $response = $this
    //            ->withHeaders($adminHeaders)
    //            ->put("/api/admin/games/{$gameId}", $updateData);
    //        $response->assertStatus(200);
    //
    //        $userHeaders = $this->registerAndLoginUser();
    //
    //        $this
    //            ->withHeaders($userHeaders)
    //            ->post("/api/users/games/{$gameId}/play");
    //
    //        $response = $this
    //            ->withHeaders($userHeaders)
    //            ->get("/api/admin/games/{$gameId}/players");
    //        $response->assertStatus(200);
    //
    //        $content = json_decode($response->getContent(), true);
    //
    //        $playerId = $content['data'][0]['user']['id'];
    //
    //        $response = $this
    //            ->withHeaders($userHeaders)
    //            ->delete("/api/admin/games/{$gameId}/players/{$playerId}");
    //        $response->assertStatus(200);
    //
    //        $content = json_decode($response->getContent(), true);
    //
    //
    //    }


}
