<?php

namespace App\Http\Controllers\Maps;

use App\Http\Controllers\Controller;
use App\Http\Services\Maps\MapAdminService;
use App\Http\Transformers\Maps\MapAdminTransformer;
use Illuminate\Http\JsonResponse;

class MapAdminController extends Controller
{
    /**
     * @var MapAdminService/
     */
    private MapAdminService $service;

    /**
     * @var MapAdminTransformer
     */
    private MapAdminTransformer $transformer;

    public function __construct(
        MapAdminService $service,
        MapAdminTransformer $transformer
    )
    {
        $this->service = $service;
        $this->transformer = $transformer;
    }

    /**
     * @OA\Get(
     *     path="/api/admin/maps",
     *     description="Get Maps",
     *     summary="Get Maps",
     *     operationId="getMaps",
     *     security={{"bearerAuth":{}}},
     *     tags={"Admin/Map"},
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
     *                     @OA\Items(ref="#/components/schemas/MapAdmin")
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
     *                          example="{}"
     *                     )
     *                 ),
     *             )
     *         )
     *     )
     * )
     * @return JsonResponse
     */
    public function index() : JsonResponse
    {
        $maps = $this->service->getAll();

        return $this->success($maps, $this->transformer);
    }
}
