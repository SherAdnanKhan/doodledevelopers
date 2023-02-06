<?php

namespace Tests\Feature\Kyc;

use App\Models\User;
use Tests\BaseTestCase;

class KycValidationTest extends BaseTestCase
{
    /**
     * @test
     */
    public function testCreateKycValidation()
    {
        list($user, $userHeaders) = $this->registerAndLoginUser();

        $data = [
            'user_id' => $user->id,
        ];

        $response = $this
            ->withHeaders($userHeaders)
            ->post('/api/users/kyc-validations', $data);
        $response->assertStatus(200);
        $content = json_decode($response->getContent(), true);

        $this->assertEquals('Kyc validation created successfully', $content['message']);
        $this->assertEquals($user->id, $content['data']['user']['id']);
    }

    /**
     * @test
     */
    public function testCreateKycValidationWithInvalidId()
    {
        list($user, $userHeaders) = $this->registerAndLoginUser();

        $data = [
            'user_id' => 'id',
        ];

        $response = $this
            ->withHeaders($userHeaders)
            ->post('/api/users/kyc-validations', $data);
        $response->assertStatus(422);
        $content = json_decode($response->getContent(), true);

        $this->assertEquals('The user id must be an integer.', $content['errors']['errors']['user_id'][0]);
    }

    /**
     * @test
     */
    public function testAdminApproveKycValidation()
    {
        list($user, $userHeaders) = $this->registerAndLoginUser();

        $data = [
            'user_id' => $user->id,
        ];

        $response = $this
            ->withHeaders($userHeaders)
            ->post('/api/users/kyc-validations', $data);
        $response->assertStatus(200);

        $content = json_decode($response->getContent(), true);

        $kycId = $content['data']['id'];

        $adminHeaders = $this->registerAndLoginAdmin();

        $data = [
            "status" => "approved",
            "review_notes" => "That is good"
        ];

        $response = $this
            ->withHeaders($adminHeaders)
            ->put("/api/users/kyc-validations/{$kycId}", $data);
        $response->assertStatus(200);

        $content = json_decode($response->getContent(), true);

        $this->assertEquals($kycId, $content['data']['id']);
    }

    //ToDo after code
//    public function testAdminApproveKycValidationWithInvalidId()
//    {
//        list($user, $userHeaders) = $this->registerAndLoginUser();
//
//        $data = [
//            'user_id' => $user->id,
//        ];
//
//        $response = $this
//            ->withHeaders($userHeaders)
//            ->post('/api/users/kyc-validations', $data);
//        $response->assertStatus(200);
//
//        $content = json_decode($response->getContent(), true);
//
//        $kycId = 10001;
//
//        $adminHeaders = $this->registerAndLoginAdmin();
//
//        $data = [
//            "status" => "approved",
//            "review_notes" => "That is good"
//        ];
//
//        $response = $this
//            ->withHeaders($adminHeaders)
//            ->put("/api/users/kyc-validations/{$kycId}", $data);
//        //$response->assertStatus(200);
//
//        $content = json_decode($response->getContent(), true);
//
//        dd($content);
//    }

    /**
     * @test
     */
    public function testGetKycValidationById()
    {
        list($user, $userHeaders) = $this->registerAndLoginUser();

        $data = [
            'user_id' => $user->id,
        ];

        $response = $this
            ->withHeaders($userHeaders)
            ->post('/api/users/kyc-validations', $data);
        $response->assertStatus(200);

        $content = json_decode($response->getContent(), true);

        $kycId = $content['data']['id'];

        $response = $this
            ->withHeaders($userHeaders)
            ->get("/api/users/kyc-validations/{$kycId}");
        $response->assertStatus(200);

        $kycValidation = json_decode($response->getContent(), true);

        $this->assertEquals('Success', $kycValidation['message']);
    }

    /**
     * @test
     */
    public function testDeleteKycValidation()
    {
        list($user, $userHeaders) = $this->registerAndLoginUser();

        $data = [
            'user_id' => $user->id,
        ];

        $response = $this
            ->withHeaders($userHeaders)
            ->post('/api/users/kyc-validations', $data);
        $response->assertStatus(200);

        $content = json_decode($response->getContent(), true);

        $kycId = $content['data']['id'];

        $response = $this
            ->withHeaders($userHeaders)
            ->delete("/api/users/kyc-validations/{$kycId}");
        $response->assertStatus(200);

        $content = json_decode($response->getContent(), true);

        $this->assertEquals('Kyc validation deleted successfully', $content['message']);
    }


}
