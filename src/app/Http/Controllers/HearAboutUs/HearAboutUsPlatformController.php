<?php

namespace App\Http\Controllers\HearAboutUs;

use App\Http\Controllers\Controller;
use App\Http\Services\HearAboutUs\HearAboutUsPlatformService;
use App\Http\Transformers\HearAboutUs\HearAboutUsPlatformTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class HearAboutUsPlatformController extends Controller
{
    /**
     * @var HearAboutUsPlatformService
     */
    private HearAboutUsPlatformService $service;

    /**
     * @var HearAboutUsPlatformTransformer
     */
    private HearAboutUsPlatformTransformer $hearAboutUsPlatformTransformer;

    public function __construct(
        HearAboutUsPlatformService $service,
        HearAboutUsPlatformTransformer $hearAboutUsPlatformTransformer
    ) {
        $this->service = $service;
        $this->hearAboutUsPlatformTransformer = $hearAboutUsPlatformTransformer;
    }

    /**
     * @OA\Get(
     *     path="/api/admin/hear-about-us-platforms",
     *     description="Get HearAboutUsPlatforms",
     *     summary="Get HearAboutUsPlatforms",
     *     operationId="getHearAboutUsPlatforms",
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
     *                     )
     *                 )
     *             )
     *         )
     *     )
     * )
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $hearAboutUsPlatforms = $this->service->getAll();

        return $this->success($hearAboutUsPlatforms, $this->hearAboutUsPlatformTransformer);
    }
}
