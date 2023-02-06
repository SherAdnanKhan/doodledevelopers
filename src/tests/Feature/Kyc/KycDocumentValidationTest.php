<?php

namespace Tests\Feature\Kyc;

use App\Models\User;
use Tests\BaseTestCase;

class KycDocumentValidationTest extends BaseTestCase
{

    private function setUpPrerequisiteriesforUploadDocument()
    {
        list($user, $userHeaders) = $this->registerAndLoginUser();

        $data = [
            'user_id' => $user->id,
        ];

        $response = $this
            ->withHeaders($userHeaders)
            ->post('/api/users/kyc-validations', $data);

        $content = json_decode($response->getContent(), true);

        return array($content, $userHeaders);
    }

    /**
     * @test
     */
    public function testUploadKycIdPdfDocument()
    {
        list($content, $userHeaders) = $this->setUpPrerequisiteriesforUploadDocument();

        $kycValidationId = $content['data']['id'];

        $data = [
            'name' => 'image.pdf',
            'type' => 'id',
            'file' => $this->getPdfImage(),
        ];

        $response = $this
            ->withHeaders($userHeaders)
            ->post("/api/users/kyc-validations/{$kycValidationId}/documents", $data);
        $response->assertStatus(200);

        $content = json_decode($response->getContent(), true);

        $this->assertEquals('Kyc validation document added successfully', $content['message']);
        $this->assertEquals('Id', $content['data']['type']['name']);
    }

    /**
     * @test
     */
    public function testUploadKycIdPngDocument()
    {
        list($content, $userHeaders) = $this->setUpPrerequisiteriesforUploadDocument();

        $kycValidationId = $content['data']['id'];

        $data = [
            'name' => 'image.png',
            'type' => 'id',
            'file' => $this->getPngImage(),
        ];

        $response = $this
            ->withHeaders($userHeaders)
            ->post("/api/users/kyc-validations/{$kycValidationId}/documents", $data);
        $response->assertStatus(200);

        $content = json_decode($response->getContent(), true);
        $this->assertEquals('Kyc validation document added successfully', $content['message']);
        $this->assertEquals('Id', $content['data']['type']['name']);
    }

    /**
     * @test
     */
    //ToDo fix the messages
    public function testUploadKycIdTxtDocumentError()
    {
        list($content, $userHeaders) = $this->setUpPrerequisiteriesforUploadDocument();

        $kycValidationId = $content['data']['id'];

        $data = [
            'name' => 'image.png',
            'type' => 'id',
            'file' => $this->getTxtfile(),
        ];

        $response = $this
            ->withHeaders($userHeaders)
            ->post("/api/users/kyc-validations/{$kycValidationId}/documents", $data);
        $response->assertStatus(422);

        $content = json_decode($response->getContent(), true);

        $this->assertEquals('Validation Error', $content['errors']['message']);
    }

    /**
     * @test
     */
    public function testUploadKycIdJpgDocument()
    {
        list($content, $userHeaders) = $this->setUpPrerequisiteriesforUploadDocument();

        $kycValidationId = $content['data']['id'];

        $data = [
            'name' => 'image.png',
            'type' => 'id',
            'file' => $this->getJpgImage(),
        ];

        $response = $this
            ->withHeaders($userHeaders)
            ->post("/api/users/kyc-validations/{$kycValidationId}/documents", $data);
        $response->assertStatus(200);

        $content = json_decode($response->getContent(), true);
        $this->assertEquals('Kyc validation document added successfully', $content['message']);
        $this->assertEquals('Id', $content['data']['type']['name']);
    }

    /**
     * @test
     */
    public function testUploadKycPassportPdfDocument()
    {
        list($content, $userHeaders) = $this->setUpPrerequisiteriesforUploadDocument();

        $kycValidationId = $content['data']['id'];

        $data = [
            'name' => 'image.pdf',
            'type' => 'passport',
            'file' => $this->getPdfImage(),
        ];

        $response = $this
            ->withHeaders($userHeaders)
            ->post("/api/users/kyc-validations/{$kycValidationId}/documents", $data);
        $response->assertStatus(200);

        $content = json_decode($response->getContent(), true);

        $this->assertEquals('Kyc validation document added successfully', $content['message']);
        $this->assertEquals('Passport', $content['data']['type']['name']);
    }

    /**
     * @test
     */
    public function testUploadKycPassportPngDocument()
    {
        list($content, $userHeaders) = $this->setUpPrerequisiteriesforUploadDocument();

        $kycValidationId = $content['data']['id'];

        $data = [
            'name' => 'image.pdf',
            'type' => 'passport',
            'file' => $this->getPngImage(),
        ];

        $response = $this
            ->withHeaders($userHeaders)
            ->post("/api/users/kyc-validations/{$kycValidationId}/documents", $data);
        $response->assertStatus(200);

        $content = json_decode($response->getContent(), true);

        $this->assertEquals('Kyc validation document added successfully', $content['message']);
        $this->assertEquals('Passport', $content['data']['type']['name']);
    }

    /**
     * @test
     */
    public function testUploadKycPassportJpgDocument()
    {
        list($content, $userHeaders) = $this->setUpPrerequisiteriesforUploadDocument();

        $kycValidationId = $content['data']['id'];

        $data = [
            'name' => 'image.pdf',
            'type' => 'passport',
            'file' => $this->getJpgImage(),
        ];

        $response = $this
            ->withHeaders($userHeaders)
            ->post("/api/users/kyc-validations/{$kycValidationId}/documents", $data);
        $response->assertStatus(200);

        $content = json_decode($response->getContent(), true);

        $this->assertEquals('Kyc validation document added successfully', $content['message']);
        $this->assertEquals('Passport', $content['data']['type']['name']);
    }

    /**
     * @test
     */
    public function testUpdateKycDocument()
    {
        list($content, $userHeaders) = $this->setUpPrerequisiteriesforUploadDocument();

        $kycValidationId = $content['data']['id'];

        $data = [
            'name' => 'image.pdf',
            'type' => 'id',
            'file' => $this->getPdfImage(),
        ];

        $response = $this
            ->withHeaders($userHeaders)
            ->post("/api/users/kyc-validations/{$kycValidationId}/documents", $data);
        $response->assertStatus(200);

        $content = json_decode($response->getContent(), true);

        $documentId = $content['data']['id'];

        $data = [
           'name' => 'image.pdf',
           'type' => 'passport',
           'file' => $this->getPdfImage(),
        ];

        $response = $this
            ->withHeaders($userHeaders)
            ->put("/api/users/kyc-validations/{$kycValidationId}/documents/{$documentId}", $data);

        $response->assertStatus(200);

        $content = json_decode($response->getContent(), true);

        $this->assertEquals('Kyc validation document updated successfully', $content['message']);
        $this->assertEquals($documentId, $content['data']['id']);
    }

    //ToDo after check
//    public function testUpdateKycDocumentWithInvalidDocumentId()
//    {
//        list($content, $userHeaders) = $this->setUpPrerequisiteriesforUploadDocument();
//
//        $kycValidationId = $content['data']['id'];
//
//        $data = [
//            'name' => 'image.pdf',
//            'type' => 'id',
//            'file' => $this->getPdfImage(),
//        ];
//
//        $response = $this
//            ->withHeaders($userHeaders)
//            ->post("/api/users/kyc-validations/{$kycValidationId}/documents", $data);
//        $response->assertStatus(200);
//
//        $content = json_decode($response->getContent(), true);
//
//        $documentId = 100;
//
//        $data = [
//            'name' => 'image.pdf',
//            'type' => 'passport',
//            'file' => $this->getPdfImage(),
//        ];
//
//        $response = $this
//            ->withHeaders($userHeaders)
//            ->put("/api/users/kyc-validations/{$kycValidationId}/documents/{$documentId}", $data);
//
//        //$response->assertStatus(200);
//
//        $content = json_decode($response->getContent(), true);
//        //dd($content);
//
//        $this->assertEquals('Kyc validation document updated successfully', $content['message']);
//        $this->assertEquals($documentId, $content['data']['id']);
//    }

    /**
     * @test
     */
    public function testGetUploadedDocumentById()
    {
        list($content, $userHeaders) = $this->setUpPrerequisiteriesforUploadDocument();

        $kycValidationId = $content['data']['id'];

        $data = [
            'name' => 'image.pdf',
            'type' => 'id',
            'file' => $this->getPdfImage(),
        ];

        $response = $this
            ->withHeaders($userHeaders)
            ->post("/api/users/kyc-validations/{$kycValidationId}/documents", $data);
        $response->assertStatus(200);

        $content = json_decode($response->getContent(), true);

        $kycDocumentId = $content['data']['id'];

        $response = $this
            ->withHeaders($userHeaders)
            ->get("/api/users/kyc-validations/{$kycValidationId}/documents/{$kycDocumentId}");
        $response->assertStatus(200);

        $kycDocument = json_decode($response->getContent(), true);

        $this->assertEquals($kycDocumentId, $kycDocument['data']['id']);
    }

    /**
     * @test
     */
    public function testDeleteUploadedDocument()
    {
        list($content, $userHeaders) = $this->setUpPrerequisiteriesforUploadDocument();

        $kycValidationId = $content['data']['id'];

        $data = [
            'name' => 'image.pdf',
            'type' => 'id',
            'file' => $this->getPdfImage(),
        ];

        $response = $this
            ->withHeaders($userHeaders)
            ->post("/api/users/kyc-validations/{$kycValidationId}/documents", $data);
        $response->assertStatus(200);

        $content = json_decode($response->getContent(), true);

        $kycDocumentId = $content['data']['id'];

        $response = $this
            ->withHeaders($userHeaders)
            ->delete("/api/users/kyc-validations/{$kycValidationId}/documents/{$kycDocumentId}");

        $content = json_decode($response->getContent(), true);

        $this->assertEquals('Kyc validation document deleted successfully', $content['message']);
    }

    /**
     * @test
     */
    public function testDuplicateUploadDocumentError()
    {
        list($content, $userHeaders) = $this->setUpPrerequisiteriesforUploadDocument();

        $kycValidationId = $content['data']['id'];

        $data = [
            'name' => 'image.pdf',
            'type' => 'id',
            'file' => $this->getPdfImage(),
        ];

        $response = $this
            ->withHeaders($userHeaders)
            ->post("/api/users/kyc-validations/{$kycValidationId}/documents", $data);
        $response->assertStatus(200);

        $response = $this
            ->withHeaders($userHeaders)
            ->post("/api/users/kyc-validations/{$kycValidationId}/documents", $data);
        $response->assertStatus(500);
        $content = json_decode($response->getContent(), true);

        $this->assertEquals('KYC validation document already exists', $content['message']);
    }




}
