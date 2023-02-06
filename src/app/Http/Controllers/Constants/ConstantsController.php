<?php

namespace App\Http\Controllers\Constants;

use App\Http\Controllers\Controller;
use App\Http\Transformers\Constants\ConstantsTransformer;
use Illuminate\Http\JsonResponse;

class ConstantsController extends Controller
{
    /**
     * @var ConstantsTransformer
     */
    private ConstantsTransformer $transformer;

    public function __construct(ConstantsTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    /**
     * @OA\Get(
     *     path="/api/constants",
     *     description="Get Constants",
     *     summary="Get Constants",
     *     operationId="getConstants",
     *     tags={"Constant"},
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
     *                     @OA\Property(
     *                         property="kycValidationStatuses",
     *                         type="array",
     *                         @OA\Items(
     *                             @OA\Property(
     *                                 property="id",
     *                                 type="string",
     *                                 example="new"
     *                             ),
     *                             @OA\Property(
     *                                 property="name",
     *                                 type="string",
     *                                 example="New"
     *                             ),
     *                         ),
     *                     ),
     *                     @OA\Property(
     *                         property="kycValidationDocumentTypes",
     *                         type="array",
     *                         @OA\Items(
     *                             @OA\Property(
     *                                 property="id",
     *                                 type="string",
     *                                 example="id"
     *                             ),
     *                             @OA\Property(
     *                                 property="name",
     *                                 type="string",
     *                                 example="Id"
     *                             ),
     *                         ),
     *                     ),
     *                     @OA\Property(
     *                         property="gameStatuses",
     *                         type="array",
     *                         @OA\Items(
     *                             @OA\Property(
     *                                 property="id",
     *                                 type="string",
     *                                 example="notstarted"
     *                             ),
     *                             @OA\Property(
     *                                 property="name",
     *                                 type="string",
     *                                 example="Not Started"
     *                             ),
     *                         ),
     *                     ),
     *                     @OA\Property(
     *                         property="gameWinnerEarningStatuses",
     *                         type="array",
     *                         @OA\Items(
     *                             @OA\Property(
     *                                 property="id",
     *                                 type="string",
     *                                 example="new"
     *                             ),
     *                             @OA\Property(
     *                                 property="name",
     *                                 type="string",
     *                                 example="New"
     *                             ),
     *                         ),
     *                     ),
     *                 ),
     *             )
     *         )
     *     )
     * )
     */
    /**
     * @return JsonResponse
     */
    public function index() : JsonResponse
    {
        return $this->success(json_encode([]), $this->transformer);
    }
}
