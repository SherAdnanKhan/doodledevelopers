<?php

namespace Tests\Feature\User;

use App\Models\User;
use Tests\BaseTestCase;
use Illuminate\Http\Response;

class AccountTest extends BaseTestCase
{
    /**
     * @test
     */
    public function testUpdatePassword()
    {
        list($user, $userHeaders) = $this->registerAndLoginUser();

        $data = [
            'password' => 'test@123',
            'new_password' => 'test@1234',
            'confirm_password' => 'test@1234',
        ];

        $response=$this
            ->withHeaders($userHeaders)
            ->put("/api/users/update-password/{$user->id}", $data);

        $response = json_decode($response->getContent(), true);

        $this->assertEquals('Password is changed', $response['message']);

        $loginData = [
            'email' => $user->email,
            'password' => 'test@123',
        ];

        $loginUser = $this->loginUser($loginData);

        $loginUser->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * @test
     */

    public function testWithOldWrongPassword()
    {
        list($user, $userHeaders) = $this->registerAndLoginUser();

        $data = [
            'password' => 'testing@123',
            'new_password' => 'test@1234',
            'confirm_password' => 'test@1234',
        ];

        $response=$this
            ->withHeaders($userHeaders)
            ->put("/api/users/update-password/{$user->id}", $data);

        $response->assertStatus(Response::HTTP_BAD_REQUEST);

        $response = json_decode($response->getContent(), true);

        $this->assertEquals('Your password field cannot match the old password.', $response['message']);
    }

    /**
     * @test
     */
    public function testWithWrongConfirmPassword()
    {
        list($user, $userHeaders) = $this->registerAndLoginUser();

        $data = [
            'password' => 'test@123',
            'new_password' => 'test@1234',
            'confirm_password' => 'test@12345',
        ];

        $response=$this
            ->withHeaders($userHeaders)
            ->put("/api/users/update-password/{$user->id}", $data);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        $response = json_decode($response->getContent(), true);

        $this->assertEquals('Validation Error', $response['errors']['message']);
    }


}
