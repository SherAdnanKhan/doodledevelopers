<?php

namespace App\Http\Controllers\Payments\Red6six;

use App\Exceptions\ErrorException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Payments\Red6six\CreateWithdrawalRequest;
use App\Http\Services\Payments\Red6six\WithdrawalService;
use App\Http\Transformers\Payments\Red6six\WithdrawalTransformer;
use App\Models\Withdrawal;
use Illuminate\Http\JsonResponse;

class WithdrawalController extends Controller
{
    /**
     * @var WithdrawalService/
     */
    private WithdrawalService $service;

    /**
     * @var WithdrawalTransformer
     */
    private WithdrawalTransformer $transformer;

    public function __construct(
        WithdrawalService $service,
        WithdrawalTransformer $transformer
    )
    {
        $this->service = $service;
        $this->transformer = $transformer;
    }

    public function index() : JsonResponse
    {
        $withdrawals = $this->service->getAll();

        return $this->success($withdrawals, $this->transformer);
    }

    public function store(CreateWithdrawalRequest $request) : JsonResponse
    {
        $withdrawal = $this->service->store($request->validated());

        return $this->success($withdrawal, $this->transformer);
    }

    public function show(Withdrawal $withdrawal) : JsonResponse
    {
        return $this->success($withdrawal, $this->transformer);
    }
}
