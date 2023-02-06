<?php

namespace App\Http\Controllers\Users;

use App\Exceptions\ErrorException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Users\GetUserRequest;
use App\Http\Requests\Users\UserAccountDisableRequest;
use App\Http\Requests\Users\UserUpdateAdminRequest;
use App\Http\Services\Users\UserAdminService;
use App\Http\Transformers\Users\UserAdminTransformer;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class UserAdminController extends Controller
{
    /**
     * @var UserAdminService
     */
    private UserAdminService $service;

    /**
     * @var UserAdminTransformer
     */
    private UserAdminTransformer $transformer;

    public function __construct(
        UserAdminService $service,
        UserAdminTransformer $transformer
    ) {
        $this->service = $service;
        $this->transformer = $transformer;
    }

    /**
     * @OA\Get (
     *     path="/api/admin/users",
     *     description="Get Users",
     *     summary="Get Users",
     *     operationId="getUsers",
     *     security={{"bearerAuth":{}}},
     *     tags={"Admin/User"},
     *     @OA\Parameter(
     *         name="status",
     *         in="query",
     *         style="form",
     *         explode=false,
     *         description="Get User from one of these statuses",
     *         @OA\Schema(
     *             type="string",
     *             enum={"new", "active", "disabled"},
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
     *                    allOf={
     *                         @OA\Schema(ref="#/components/schemas/UserAdmin")
     *                     }
     *                 ),
     *             )
     *         )
     *     )
     * )
     * @param GetUserRequest $request
     * @return JsonResponse
     */
    public function index(GetUserRequest $request) : JsonResponse
    {
        $users = $this->service->getAll($request->validated());

        return $this->success($users, $this->transformer);
    }

    /**
     * @OA\Get(
     *     path="/api/admin/users/{user}",
     *     description="Get User",
     *     summary="Get User",
     *     operationId="getUser",
     *     security={{"bearerAuth":{}}},
     *     tags={"Admin/User"},
     *     @OA\Parameter(
     *         @OA\Schema(type="integer"),
     *         in="path",
     *         allowReserved=true,
     *         required=true,
     *         name="user",
     *         parameter="user",
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
     *                         @OA\Schema(ref="#/components/schemas/UserAdmin")
     *                     }
     *                 ),
     *             )
     *         )
     *     )
     * )
     * @param User $user
     * @return JsonResponse
     */
    public function show(User $user) : JsonResponse
    {
        return $this->success($user, $this->transformer);
    }

    /**
     * @OA\Put (
     *     path="/api/admin/users/{user}",
     *     description="Update User",
     *     summary="Update User",
     *     operationId="updateUser",
     *     security={{"bearerAuth":{}}},
     *     tags={"Admin/User"},
     *     @OA\Parameter (
     *         @OA\Schema(type="integer"),
     *         in="path",
     *         allowReserved=true,
     *         required=true,
     *         name="user",
     *         parameter="user",
     *         example=1
     *     ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="is_viewed",
     *                     type="boolean",
     *                     example=1
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="User updated successfully",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                  @OA\Property(
     *                     property="message",
     *                     type="string",
     *                     example="User updated successfully"
     *                 ),
     *                  @OA\Property(
     *                     property="data",
     *                    allOf={
     *                         @OA\Schema(ref="#/components/schemas/UserAdmin")
     *                     }
     *                 ),
     *             )
     *         )
     *     )
     * )
     * @param UserUpdateAdminRequest $request
     * @param User $user
     * @return JsonResponse
     */
    public function update(UserUpdateAdminRequest $request, User $user) : JsonResponse
    {
        $this->service->update($user, $request->validated());

        return $this->success($user, $this->transformer, trans('messages.user_update_success'));
    }

    /**
     * @OA\Put (
     *     path="/api/admin/disable-user-account",
     *     description="Disable User Account",
     *     summary="Disable User Account",
     *     operationId="disableUserAccount",
     *     security={{"bearerAuth":{}}},
     *     tags={"Admin/Disable User Account"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="user_id",
     *                     type="integer",
     *                     example=1
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="User disabled successfully",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                  @OA\Property(
     *                     property="message",
     *                     type="string",
     *                     example="User disabled successfully"
     *                 ),
     *                  @OA\Property(
     *                     property="data",
     *                    allOf={
     *                         @OA\Schema(ref="#/components/schemas/UserAdmin")
     *                     }
     *                 ),
     *             )
     *         )
     *     )
     * )
     * @param UserAccountDisableRequest $request
     * @return JsonResponse
     * @throws ErrorException
     */
    public function disableUser(UserAccountDisableRequest $request) : JsonResponse
    {
        $disabledUser = $this->service->disableUser($request->validated());

        return $this->success($disabledUser, $this->transformer, trans('messages.user_disabled_success'));
    }
}
