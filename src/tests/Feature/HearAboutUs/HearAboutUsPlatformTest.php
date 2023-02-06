<?php

namespace Tests\Feature\HearAboutUs;

use App\Models\User;
use Tests\BaseTestCase;
use Illuminate\Http\Response;

class HearAboutUsPlatformTest extends BaseTestCase
{
    /**
     * @test
     */
    public function testCreateNewPlatform()
    {
        $userHeaders =$this->registerAndLoginUser();

        $data = [
            "name" => "Twitter",
            "label" => "twitter"
        ];

        $response = $this
            ->withHeaders($userHeaders)
            ->post('api/admin/hear-about-us-platforms', $data);

        $response->assertStatus(Response::HTTP_OK);

        $response = json_decode($response->getContent(), true);

        $this->assertEquals('Platform created successfully', $response['message']);
    }

    /**
     * @test
     */
    public function testCreateNewPlatformWithMissingNameField()
    {
        $userHeaders = $this->registerAndLoginUser();

        $data = [
            "label" => "twitter"
        ];

        $response = $this
            ->withHeaders($userHeaders)
            ->post('api/admin/hear-about-us-platforms', $data);


        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        $response = json_decode($response->getContent(), true);

        $this->assertEquals('Validation Error', $response['errors']['message']);
    }

    /**
     * @test
     */
    public function testCreateNewPlatformWithMissingLabelField()
    {
        $userHeaders = $this->registerAndLoginUser();

        $data = [
            "name" => "Twitter"
        ];

        $response = $this
            ->withHeaders($userHeaders)
            ->post('api/admin/hear-about-us-platforms', $data);


        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        $response = json_decode($response->getContent(), true);

        $this->assertEquals('Validation Error', $response['errors']['message']);
    }

    /**
     * @test
     */
    public function testUpdatePlatformWithSameFields()
    {
        $userHeaders = $this->registerAndLoginUser();

        $data = [
            "name" => "Twitter",
            "label" => "twitter"
        ];

        $response=$this
            ->withHeaders($userHeaders)
            ->post('api/admin/hear-about-us-platforms', $data);

        $platform = json_decode($response->getContent());

        $platformId = $platform->data->id;

        $response=$this
            ->withHeaders($userHeaders)
            ->put('api/admin/hear-about-us-platforms/'.$platformId, $data);

        $response->assertStatus(Response::HTTP_OK);

        $response = json_decode($response->getContent(), true);

        $this->assertEquals('Platform updated successfully', $response['message']);
    }

    /**
     * @test
     */
    public function testUpdatePlatform()
    {
        $userHeaders = $this->registerAndLoginUser();

        $data = [
            "name" => "Twitter",
            "label" => "twitter"
        ];

        $response=$this
            ->withHeaders($userHeaders)
            ->post('api/admin/hear-about-us-platforms', $data);

        $platform = json_decode($response->getContent());

        $platformId = $platform->data->id;

        $updatedata = [
            "name" => "Instagram",
            "label" => "instagram"
        ];

        $response=$this
            ->withHeaders($userHeaders)
            ->put('api/admin/hear-about-us-platforms/'.$platformId, $updatedata);

        $response->assertStatus(Response::HTTP_OK);

        $response = json_decode($response->getContent(), true);

        $this->assertEquals('Platform updated successfully', $response['message']);
    }

    /**
     * @test
     */

    public function testDeletePlatform()
    {
        $userHeaders = $this->registerAndLoginUser();

        $data = [
            "name" => "Twitter",
            "label" => "twitter"
        ];

        $response=$this
            ->withHeaders($userHeaders)
            ->post('api/admin/hear-about-us-platforms', $data);

        $platform = json_decode($response->getContent());

        $platformId = $platform->data->id;

        $response=$this
            ->withHeaders($userHeaders)
            ->delete('/api/admin/hear-about-us-platforms/'.$platformId);

        $response->assertStatus(Response::HTTP_OK);

        $response = json_decode($response->getContent(), true);

        $this->assertEquals('Platform deleted successfully', $response['message']);

    }
}
