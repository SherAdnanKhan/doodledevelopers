<?php

namespace App\Http\Controllers\HearAboutUs;

use App\Models\HearAboutUsPlatform;
use App\Http\Controllers\Controller;
use App\Http\Requests\HearAboutUs\CreateHearAboutUsRequest;
use App\Http\Requests\HearAboutUs\UpdateHearAboutUsRequest;
use App\Http\Services\HearAboutUs\HearAboutUsPlatformService;
use App\Http\Transformers\HearAboutUs\HearAboutUsPlatformTransformer;
use App\Http\Transformers\HearAboutUs\HearAboutUsCountTransformer;
use Illuminate\Http\JsonResponse;

class HearAboutUsPlatformAdminController extends Controller
{
    /**
     * @var HearAboutUsPlatformService
     */
    private HearAboutUsPlatformService $service;

    /**
     * @var HearAboutUsPlatformTransformer
     */
    private HearAboutUsPlatformTransformer $hearAboutUsPlatformTransformer;

    private HearAboutUsCountTransformer $hearAboutUsCountTransformer ;

    public function __construct(
        HearAboutUsPlatformService $service,
        HearAboutUsPlatformTransformer $hearAboutUsPlatformTransformer,
        HearAboutUsCountTransformer $hearAboutUsCountTransformer
    ) {
        $this->service = $service;
        $this->hearAboutUsPlatformTransformer = $hearAboutUsPlatformTransformer;
        $this->hearAboutUsCountTransformer = $hearAboutUsCountTransformer;
    }
    /**
     * @OA\Get(
     *     path="/api/users/hear-about-us-platforms",
     *     description="Get HearAboutUsPlatforms",
     *     summary="Get HearAboutUsPlatforms",
     *     operationId="getHearAboutUsPlatforms",
     *     security={{"bearerAuth":{}}},
     *     tags={"User/HearAboutUsPlatform"},
     *     @OA\Response(
     *         response="200",
     *         description="Success",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                  @OA\Property(
     *                     property="message",
     *                     type="string",
     *                     example="Success"
     *                 ),
     *                  @OA\Property(
     *                     property="data",
     *                     type="array",
     *                     @OA\Items(ref="#/components/schemas/HearAboutUsPlatform")
     *                 ),
     *                 @OA\Property(
     *                     property="pagination",
     *                     @OA\Property(
     *                         property="total",
     *                         type="integer",
     *                         example=1
     *                     ),
     *                     @OA\Property(
     *                         property="count",
     *                         type="integer",
     *                         example=1
     *                     ),
     *                     @OA\Property(
     *                         property="per_page",
     *                         type="integer",
     *                         example=10
     *                     ),
     *                     @OA\Property(
     *                         property="current_page",
     *                         type="integer",
     *                         example=1
     *                     ),
     *                     @OA\Property(
     *                         property="total_pages",
     *                         type="integer",
     *                         example=1
     *                     ),
     *                     @OA\Property(
     *                         property="links",
     *                         type="string",
     *                         example={}
     *                     )
     *                 )
     *             )
     *         )
     *     )
     * )
     * @return JsonResponse
     */
    public function index() : JsonResponse
    {
        $hearAboutUsPlatforms = $this->service->getAll();

        return $this->success($hearAboutUsPlatforms, $this->hearAboutUsPlatformTransformer);
    }

    /**
     * @OA\Post(
     *     path="/api/admin/hear-about-us-platforms",
     *     description="Create HearAboutUsPlatforms",
     *     summary="Create HearAboutUsPlatform",
     *     operationId="createHearAboutUsPlatform",
     *     security={{"bearerAuth":{}}},
     *     tags={"Admin/HearAboutUsPlatform"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="name",
     *                     type="string",
     *                     example="Twitter"
     *                 ),
     *                 @OA\Property(
     *                     property="label",
     *                     type="string",
     *                     example="twitter"
     *                 ),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Platform created successfully",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                  @OA\Property(
     *                     property="message",
     *                     type="string",
     *                     example="Platform created successfully"
     *                 ),
     *                  @OA\Property(
     *                     property="data",
     *                     allOf={
     *                         @OA\Schema(ref="#/components/schemas/HearAboutUsPlatform")
     *                     }
     *                 ),
     *             )
     *         )
     *     )
     * )
     * @param CreateHearAboutUsRequest $request
     * @return JsonResponse
     */
    public function store(CreateHearAboutUsRequest $request) : JsonResponse
    {
        $platform = $this->service->store($request->validated());

        return $this->success($platform, $this->hearAboutUsPlatformTransformer, trans('messages.hear_about_us_success'));
    }

    /**
     * @OA\Get(
     *     path="/api/admin/hear-about-us-platforms/{hear_about_us_platform}",
     *     description="Get HearAboutUsPlatform",
     *     summary="Get HearAboutUsPlatform",
     *     operationId="getHearAboutUsPlatform",
     *     security={{"bearerAuth":{}}},
     *     tags={"Admin/HearAboutUsPlatform"},
     *     @OA\Parameter(
     *         @OA\Schema(type="integer"),
     *         in="path",
     *         allowReserved=true,
     *         required=true,
     *         name="hear_about_us_platform",
     *         parameter="hear_about_us_platform",
     *         example=1
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Success",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                  @OA\Property(
     *                     property="message",
     *                     type="string",
     *                     example="Success"
     *                 ),
     *                  @OA\Property(
     *                     property="data",
     *                     allOf={
     *                         @OA\Schema(ref="#/components/schemas/HearAboutUsPlatform")
     *                     }
     *                 ),
     *             )
     *         )
     *     )
     * )
     * @param HearAboutUsPlatform $hearAboutUsPlatform
     * @return JsonResponse
     */
    public function show(HearAboutUsPlatform $hearAboutUsPlatform) : JsonResponse
    {
        return $this->success($hearAboutUsPlatform, $this->hearAboutUsPlatformTransformer);
    }

    /**
     * @OA\Put(
     *     path="/api/admin/hear-about-us-platforms/{hear_about_us_platform}",
     *     description="Update HearAboutUsPlatform",
     *     summary="Update HearAboutUsPlatform",
     *     operationId="updateHearAboutUsPlatform",
     *     security={{"bearerAuth":{}}},
     *     tags={"Admin/HearAboutUsPlatform"},
     *     @OA\Parameter(
     *         @OA\Schema(type="integer"),
     *         in="path",
     *         allowReserved=true,
     *         required=true,
     *         name="hear_about_us_platform",
     *         parameter="hear_about_us_platform",
     *         example=1
     *     ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="name",
     *                     type="string",
     *                     example="Twitter"
     *                 ),
     *                 @OA\Property(
     *                     property="label",
     *                     type="string",
     *                     example="twitter"
     *                 ),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Platform updated successfully",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                  @OA\Property(
     *                     property="message",
     *                     type="string",
     *                     example="Platform updated successfully"
     *                 ),
     *                  @OA\Property(
     *                     property="data",
     *                     allOf={
     *                         @OA\Schema(ref="#/components/schemas/HearAboutUsPlatform")
     *                     }
     *                 ),
     *             )
     *         )
     *     )
     * )
     * @param UpdateHearAboutUsRequest $request
     * @param HearAboutUsPlatform $hearAboutUsPlatform
     * @return JsonResponse
     */
    public function update(UpdateHearAboutUsRequest $request, HearAboutUsPlatform $hearAboutUsPlatform) : JsonResponse
    {
        $this->service->update($hearAboutUsPlatform, $request->validated());

        return $this->success($hearAboutUsPlatform, $this->hearAboutUsPlatformTransformer, trans('messages.hear_about_us_updated'));
    }

    /**
     * @OA\Delete(
     *     path="/api/admin/hear-about-us-platforms/{hear_about_us_platform}",
     *     description="Delete HearAboutUsPlatform",
     *     summary="Delete HearAboutUsPlatform",
     *     operationId="deleteHearAboutUsPlatform",
     *     security={{"bearerAuth":{}}},
     *     tags={"Admin/HearAboutUsPlatform"},
     *     @OA\Parameter(
     *         @OA\Schema(type="integer"),
     *         in="path",
     *         allowReserved=true,
     *         required=true,
     *         name="hear_about_us_platform",
     *         parameter="hear_about_us_platform",
     *         example=1
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Platform deleted successfully",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                  @OA\Property(
     *                     property="message",
     *                     type="string",
     *                     example="Platform deleted successfully"
     *                 ),
     *                  @OA\Property(
     *                     property="data",
     *                     example="[]"
     *                 ),
     *             )
     *         )
     *     )
     * )
     * @param HearAboutUsPlatform $hearAboutUsPlatform
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy(HearAboutUsPlatform $hearAboutUsPlatform) : JsonResponse
    {
        $this->service->delete($hearAboutUsPlatform);

        return $this->success([], null, trans('messages.hear_about_us_delete'));
    }

    /**
     * @OA\Get(
     *     path="/api/admin/hear-about-us-platform-count",
     *     description="Get HearAboutUsPlatformsCount",
     *     summary="Get HearAboutUsPlatformsCount",
     *     operationId="getHearAboutUsPlatformsCount",
     *     security={{"bearerAuth":{}}},
     *     tags={"Admin/HearAboutUsPlatform"},
     *     @OA\Response(
     *         response="200",
     *         description="Success",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                  @OA\Property(
     *                     property="message",
     *                     type="string",
     *                     example="Success"
     *                 ),
     *                  @OA\Property(
     *                     property="data",
     *                     type="array",
     *                     @OA\Items(ref="#/components/schemas/HearAboutUsPlatformCount")
     *                 ),
     *                 @OA\Property(
     *                     property="pagination",
     *                     @OA\Property(
     *                         property="total",
     *                         type="integer",
     *                         example=1
     *                     ),
     *                     @OA\Property(
     *                         property="count",
     *                         type="integer",
     *                         example=1
     *                     ),
     *                     @OA\Property(
     *                         property="per_page",
     *                         type="integer",
     *                         example=10
     *                     ),
     *                     @OA\Property(
     *                         property="current_page",
     *                         type="integer",
     *                         example=1
     *                     ),
     *                     @OA\Property(
     *                         property="total_pages",
     *                         type="integer",
     *                         example=1
     *                     )
     *                 )
     *             )
     *         )
     *     )
     * )
     * @return JsonResponse
     */
    public function hearAboutUsPlatformCount() : JsonResponse
    {
        $platformCount = $this->service->hearAboutUsCount();

        return $this->success($platformCount, $this->hearAboutUsCountTransformer);
    }
}
