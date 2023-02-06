<?php

namespace App\Http\Controllers\Games;

use App\Http\Controllers\Controller;
use App\Http\Services\Games\GameEarningAdminService;
use App\Http\Transformers\Wallets\GameTransactionTransformer;
use App\Models\GameTransaction;
use Illuminate\Http\JsonResponse;

class GameEarningAdminController extends Controller
{
    /**
     * @var GameEarningAdminService/
     */
    private GameEarningAdminService $service;

    /**
     * @var GameTransactionTransformer
     */
    private GameTransactionTransformer $transformer;

    public function __construct(
        GameEarningAdminService $service,
        GameTransactionTransformer $transformer
    )
    {
        $this->service = $service;
        $this->transformer = $transformer;
    }

    /**
     * @OA\Get(
     *     path="/api/admin/earnings",
     *     description="Get Games Earnings",
     *     summary="Get Games Earnings",
     *     operationId="getGamesEarnings",
     *     security={{"bearerAuth":{}}},
     *     tags={"Admin/Earning"},
     *     @OA\Parameter(
     *         name="include",
     *         in="query",
     *         style="form",
     *         explode=false,
     *         @OA\Schema(
     *             type="array",
     *             @OA\Items( type="enum", enum={"game", "wallet"} ),
     *             example={"game"}
     *         )
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
     *                     type="array",
     *                     @OA\Items(ref="#/components/schemas/GameTransaction")
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
     *                         @OA\Property(
     *                             property="previous",
     *                             type="string",
     *                             example="{}"
     *                         ),
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
        $gameEarnings = $this->service->getAll();

        return $this->success($gameEarnings, $this->transformer);
    }

    /**
     * @OA\Get(
     *     path="/api/admin/earning",
     *     description="Get Admin Game Earning",
     *     summary="Get Admin Game Earning",
     *     operationId="getAdminGameEarning",
     *     security={{"bearerAuth":{}}},
     *     tags={"Admin/Earning"},
     *     @OA\Parameter(
     *         name="include",
     *         in="query",
     *         style="form",
     *         explode=false,
     *         @OA\Schema(
     *             type="array",
     *             @OA\Items( type="enum", enum={"game", "wallet"} ),
     *             example={"game"}
     *         )
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
     *                     type="array",
     *                     @OA\Items(ref="#/components/schemas/GameTransaction")
     *                 ),
     *             )
     *         )
     *     )
     * )
     * @return JsonResponse
     */
    public function getEarning(): JsonResponse
    {
       $gameAdminEarning = $this->service->getEarning();

       return $this->success($gameAdminEarning, $this->transformer);
    }

    /**
     * @OA\Get(
     *     path="/api/admin/earnings/{earning}",
     *     description="Get Earning",
     *     summary="Get Earning",
     *     operationId="getEarning",
     *     security={{"bearerAuth":{}}},
     *     tags={"Admin/Earning"},
     *     @OA\Parameter(
     *         @OA\Schema(type="integer"),
     *         in="path",
     *         allowReserved=true,
     *         required=true,
     *         name="earning",
     *         parameter="earning",
     *         example=1
     *     ),
     *      @OA\Parameter(
     *         name="include",
     *         in="query",
     *         style="form",
     *         explode=false,
     *         @OA\Schema(
     *             type="array",
     *             @OA\Items( type="enum", enum={"game", "wallet"} ),
     *             example={"game"}
     *         )
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
     *                         @OA\Schema(ref="#/components/schemas/GameTransaction")
     *                     }
     *                 ),
     *             )
     *         )
     *     )
     * )
     * @param GameTransaction $earning
     * @return JsonResponse
     */
    public function show(GameTransaction $earning) : JsonResponse
    {
        return $this->success($earning, $this->transformer);
    }

}
