<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\BaseTestCase;
use Illuminate\Http\Response;

class AuthenticationTest extends BaseTestCase
{
    /**
     * @test
     */
    public function testRegisterUser()
    {
        $response = $this->registerUser();

        $user = json_decode($response->getContent(), true);

        $this->assertEquals('User created successfully', $user['message']);
    }

    /**
     * @test
     */
    public function testLoginUser()
    {
        $user = factory(User::class)->create();

        $loginData = [
            'email' => $user->email,
            'password' => 'test@123',
        ];

        $loginUser = $this->loginUser($loginData);

        $loginUser = json_decode($loginUser->getContent(), true);

        $this->assertEquals('User logged in successfully', $loginUser['message']);
        $this->assertArrayHasKey('access_token', $loginUser['data']);
        $this->assertArrayHasKey('token_type', $loginUser['data']);
    }

    /**
     * @test
     */
    public function testUnAuthenticatedLoginUser()
    {
        factory(User::class)->create();

        $loginData = [
            'email' => "wrong@gmail.com",
            'password' => 'wrong',
        ];

        $loginUser = $this->loginUser($loginData);

        $loginUser->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

    }

    public function testLogoutUser()
    {
        $user = factory(User::class)->create();

        $loginData = [
            'email' => $user->email,
            'password' => 'test@123',
        ];

        $loginUserWithHeaders = $this->loginUserWithToken($loginData);

        $response=$this
            ->withHeaders($loginUserWithHeaders)
            ->get('api/auth/logout');

        $content = json_decode($response->getContent());
        $this->assertEquals("User logged out successfully", $content->message);
    }
}
