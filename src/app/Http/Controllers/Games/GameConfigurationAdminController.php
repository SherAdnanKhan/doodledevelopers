<?php

namespace App\Http\Controllers\Games;

use App\Http\Controllers\Controller;
use App\Http\Requests\Games\GetGameRequest;
use App\Http\Services\Games\GameConfigurationAdminService;
use App\Http\Transformers\Games\GameConfigurationAdminTransformer;
use App\Http\Requests\Games\CreateGameConfigurationRequest;
use App\Http\Requests\Games\UpdateGameConfigurationRequest;
use App\Models\GameConfiguration;
use Illuminate\Http\JsonResponse;

class GameConfigurationAdminController extends Controller
{

    /**
     * @var GameConfigurationAdminService
     */
    private GameConfigurationAdminService $service;

    /**
     * @var GameConfigurationAdminTransformer
     */
    private GameConfigurationAdminTransformer $transformer;

    public function __construct(
        GameConfigurationAdminService $service,
        GameConfigurationAdminTransformer $transformer
    )
    {
        $this->service = $service;
        $this->transformer = $transformer;
    }

    /**
     * @OA\Get(
     *     path="/api/admin/configurations",
     *     description="Get Configurations",
     *     summary="Get Configurations",
     *     operationId="getConfigurations",
     *     security={{"bearerAuth":{}}},
     *     tags={"Admin/Game Configurations"},
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
     *                     @OA\Items(ref="#/components/schemas/GameConfiguration")
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
     *                         example="{}"
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
       $configurations = $this->service->getAll();

       return $this->success($configurations, $this->transformer);
    }

    /**
     * @OA\Post(
     *     path="/api/admin/configurations",
     *     description="Create Configuration",
     *     summary="Create Configuration",
     *     operationId="createConfiguration",
     *     security={{"bearerAuth":{}}},
     *     tags={"Admin/Game Configurations"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="currency_conversion_duration",
     *                     type="integer",
     *                     example=30
     *                 ),
     *                 @OA\Property(
     *                     property="min_deposit_amount",
     *                     type="integer",
     *                     example=500
     *                 ),
     *                 @OA\Property(
     *                     property="max_deposit_amount",
     *                     type="integer",
     *                     example=3000000
     *                 ),
     *                 @OA\Property(
     *                     property="min_withdrawal_amount",
     *                     type="integer",
     *                     example=500
     *                 ),
     *                 @OA\Property(
     *                     property="max_withdrawal_amount",
     *                     type="integer",
     *                     example=3000000
     *                 ),
     *                 @OA\Property(
     *                     property="amount_of_balls_to_fire",
     *                     type="integer",
     *                     example=5
     *                 ),
     *                 @OA\Property(
     *                     property="total_attempts",
     *                     type="integer",
     *                     example=3
     *                 ),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Configuration created successfully",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                  @OA\Property(
     *                     property="message",
     *                     type="string",
     *                     example="Configuration created successfully"
     *                 ),
     *                  @OA\Property(
     *                     property="data",
     *                     allOf={
     *                         @OA\Schema(ref="#/components/schemas/GameConfiguration")
     *                     }
     *                 ),
     *             )
     *         )
     *     )
     * )
     * @param CreateGameConfigurationRequest $request
     * @return JsonResponse
     */
    public function store(CreateGameConfigurationRequest $request) : JsonResponse
    {
       $configuration = $this->service->store($request->validated());

       return $this->success($configuration, $this->transformer, trans('messages.configuration_create_success'));
    }

    /**
     * @OA\Put(
     *     path="/api/admin/configurations/{configuration}",
     *     description="Update Configuration",
     *     summary="Update Configuration",
     *     operationId="updateConfiguration",
     *     security={{"bearerAuth":{}}},
     *     tags={"Admin/Game Configurations"},
     *     @OA\Parameter(
     *         @OA\Schema(type="integer"),
     *         in="path",
     *         allowReserved=true,
     *         required=true,
     *         name="configuration",
     *         parameter="configuration",
     *         example=1
     *     ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="currency_conversion_duration",
     *                     type="integer",
     *                     example=30
     *                 ),
     *                 @OA\Property(
     *                     property="min_deposit_amount",
     *                     type="integer",
     *                     example=500
     *                 ),
     *                 @OA\Property(
     *                     property="max_deposit_amount",
     *                     type="integer",
     *                     example=3000000
     *                 ),
     *                 @OA\Property(
     *                     property="min_withdrawal_amount",
     *                     type="integer",
     *                     example=500
     *                 ),
     *                 @OA\Property(
     *                     property="max_withdrawal_amount",
     *                     type="integer",
     *                     example=3000000
     *                 ),
     *                 @OA\Property(
     *                     property="amount_of_balls_to_fire",
     *                     type="integer",
     *                     example=5
     *                 ),
     *                 @OA\Property(
     *                     property="total_attempts",
     *                     type="integer",
     *                     example=3
     *                 ),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Configuration updated successfully",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                  @OA\Property(
     *                     property="message",
     *                     type="string",
     *                     example="Configuration updated successfully"
     *                 ),
     *                  @OA\Property(
     *                     property="data",
     *                     allOf={
     *                         @OA\Schema(ref="#/components/schemas/GameConfiguration")
     *                     }
     *                 ),
     *             )
     *         )
     *     )
     * )
     * @param UpdateGameConfigurationRequest $request
     * @param GameConfiguration $configuration
     * @return JsonResponse
     */
    public function update(UpdateGameConfigurationRequest $request, GameConfiguration $configuration) : JsonResponse
    {
       $this->service->update($configuration, $request->validated());

       return $this->success($configuration, $this->transformer, trans('messages.configuration_update_success'));
    }

    /**
     * @OA\Delete(
     *     path="/api/admin/configurations/{configuration}",
     *     description="Delete Configuration",
     *     summary="Delete Configuration",
     *     operationId="deleteConfiguration",
     *     security={{"bearerAuth":{}}},
     *     tags={"Admin/Game Configurations"},
     *     @OA\Parameter(
     *         @OA\Schema(type="integer"),
     *         in="path",
     *         allowReserved=true,
     *         required=true,
     *         name="configuration",
     *         parameter="configuration",
     *         example=1
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Configuration deleted successfully",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                  @OA\Property(
     *                     property="message",
     *                     type="string",
     *                     example="Configuration deleted successfully"
     *                 ),
     *                  @OA\Property(
     *                     property="data",
     *                     example="[]"
     *                 ),
     *             )
     *         )
     *     )
     * )
     * @param GameConfiguration $configuration
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy(GameConfiguration $configuration) : JsonResponse
    {
        $this->service->destroy($configuration);

        return $this->success([], null, trans('messages.configuration_delete_success'));
    }
}
