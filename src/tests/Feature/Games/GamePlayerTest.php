<?php

namespace Tests\Feature\Games;

use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Tests\BaseTestCase;
use App\Models\GameWinnerEarnings;
use Illuminate\Support\Carbon;

class GamePlayerTest extends BaseTestCase
{
    private function createAndUpdateGame(array $data, $adminHeaders)
    {
        $response = $this
            ->withHeaders($adminHeaders)
            ->post('/api/admin/games', $data);
        $response->assertStatus(200);

        $content = json_decode($response->getContent(), true);

        $gameId = $content['data']['id'];

        $updateData = [
            "status" => "live",
            "pot_value" => 12000
        ];

        $response = $this
            ->withHeaders($adminHeaders)
            ->put("/api/admin/games/{$gameId}", $updateData);
        $response->assertStatus(200);

        return $gameId;

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
    //ToDo set the response after code modification
    public function testUserPlayGameSuccess()
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

        $gameId = $this->createAndUpdateGame($data, $adminHeaders);

        $userHeaders = $this->registerAndLoginUser();
        $response = $this
            ->withHeaders($userHeaders)
            ->post("/api/users/games/{$gameId}/play");
        $response->assertStatus(200);

        $content = json_decode($response->getContent(), true);

        $this->assertEquals("Player is ready to play the game!", $content['message']);
    }

    /**
     * @test
     */
    //ToDO set the response when code is modified
    public function testCreateUserScore()
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

        $gameId = $this->createAndUpdateGame($data, $adminHeaders);

        $userHeaders = $this->registerAndLoginUser();
        $response = $this
            ->withHeaders($userHeaders)
            ->post("/api/users/games/{$gameId}/play");
        $response->assertStatus(200);

        $data = [
            "score"  => 11,
            "duration"  => 4.331234
        ];

        $response = $this
            ->withHeaders($userHeaders)
            ->post("/api/users/games/{$gameId}/scores" , $data);
        $response->assertStatus(200);

        $content = json_decode($response->getContent(), true);

        $this->assertEquals('Success', $content['message']);
    }

    /**
     * @test
     */
    //ToDo set the response after code modification
    public function testPlayGameWithInvalidScore()
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

        $gameId = $this->createAndUpdateGame($data, $adminHeaders);

        $userHeaders = $this->registerAndLoginUser();
        $response = $this
            ->withHeaders($userHeaders)
            ->post("/api/users/games/{$gameId}/play");
        $response->assertStatus(200);

        $data = [
            "score"  => "-11.8925",
            "duration"  => "4.331234"
        ];

        $response = $this
            ->withHeaders($userHeaders)
            ->post("/api/users/games/{$gameId}/scores" , $data);
        $response->assertStatus(200);

        $content = json_decode($response->getContent(), true);

        $this->assertEquals('Success', $content['message']);
    }

    /**
     * @test
     */
    public function testPlayGameWithInvalidDuration()
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

        $gameId = $this->createAndUpdateGame($data, $adminHeaders);

        $userHeaders = $this->registerAndLoginUser();
        $response = $this
            ->withHeaders($userHeaders)
            ->post("/api/users/games/{$gameId}/play");
        $response->assertStatus(200);

        $data = [
            "score"  => "11",
            "duration"  => "alert('1.11')",
        ];

        $response = $this
            ->withHeaders($userHeaders)
            ->post("/api/users/games/{$gameId}/scores" , $data);
       $response->assertStatus(422);

        $content = json_decode($response->getContent(), true);

        $this->assertEquals('Validation Error', $content['errors']['message']);
        $this->assertEquals('The duration must be a number.', $content['errors']['errors']['duration'][0]);
    }

    /**
     * @test
     */
    public function testPlayersGameWinnerEarnings()
    {
        $adminHeaders = $this->registerAndLoginAdmin();

        $data = [
            "jackpot_value" => 10000,
            "admin_fee_percentage" => 30,
            "entry_fee" => 100,
            "game_ext_days" => 3,
            "start_date" => $this->getTodayDate(),
            "end_date" => $this->getTodayDate(),
        ];

        $gameId = $this->createAndUpdateGame($data, $adminHeaders);

        $userHeaders = $this->registerAndLoginUser();
        $response = $this
            ->withHeaders($userHeaders)
            ->post("/api/users/games/{$gameId}/play");
        $response->assertStatus(200);

        $playerOneScore = [
            "score"  => "11",
            "duration"  => "4.331"
        ];

        $response = $this
            ->withHeaders($userHeaders)
            ->post("/api/users/games/{$gameId}/scores" , $playerOneScore);
        $response->assertStatus(200);

        $userHeaders = $this->registerAndLoginUser();
        $response = $this
            ->withHeaders($userHeaders)
            ->post("/api/users/games/{$gameId}/play");
        $response->assertStatus(200);

        $playerTwoScore = [
            "score"  => "12",
            "duration"  => "5.331"
        ];

        $response = $this
            ->withHeaders($userHeaders)
            ->post("/api/users/games/{$gameId}/scores" , $playerTwoScore);
        $response->assertStatus(200);

        Artisan::call('game:end');

        $gamePlayers = GameWinnerEarnings::where('game_id', $gameId)->count();

        $this->assertEquals(2, $gamePlayers);
    }

    /**
     * @test
     */
    public function testPlayerGameScores()
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

        $gameId = $this->createAndUpdateGame($data, $adminHeaders);

        $userHeaders = $this->registerAndLoginUser();
        $response = $this
            ->withHeaders($userHeaders)
            ->post("/api/users/games/{$gameId}/play");
        $response->assertStatus(200);

        $data = [
            "score"  => "11",
            "duration"  => "6.989"
        ];

        $response = $this
            ->withHeaders($userHeaders)
            ->post("/api/users/games/{$gameId}/scores" , $data);
        $response->assertStatus(200);

        $response = $this
            ->withHeaders($userHeaders)
            ->post("/api/users/games/{$gameId}/play");
        $response->assertStatus(200);

        $data = [
            "score"  => "15",
            "duration"  => "3.19"
        ];

        $response = $this
            ->withHeaders($userHeaders)
            ->post("/api/users/games/{$gameId}/scores" , $data);
        $response->assertStatus(200);


        $response = $this
            ->withHeaders($userHeaders)
            ->get("/api/users/games/{$gameId}/scores");
        $response->assertStatus(200);

        $content = json_decode($response->getContent(), true);

        $this->assertEquals(2, count($content['data']));
    }

    /**
     * @test
     */
    //ToDo handle the exception message after code modification
//    public function testUserPlayGameWithInvalidId()
//    {
//        $adminHeaders = $this->registerAndLoginAdmin();
//
//        $data = [
//            "jackpot_value" => 10000,
//            "admin_fee_percentage" => 30,
//            "entry_fee" => 100,
//            "game_ext_days" => 3,
//            "start_date" => "2020-10-14",
//            "end_date" => "2020-10-17",
//        ];
//
//        $this->createAndUpdateGame($data, $adminHeaders);
//
//        $userHeaders = $this->registerAndLoginUser();
//
//        $response = $this
//            ->withHeaders($userHeaders)
//            ->post("/api/users/games/{-9}/play");
//        //$response->assertStatus(200);
//
//        $content = json_decode($response->getContent(), true);
//
//
//    }
}
