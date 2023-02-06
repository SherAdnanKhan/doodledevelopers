<?php

namespace App\Http\Transformers\Wallets;

use App\Http\Transformers\BaseTransformer;
use App\Http\Transformers\Constants\CurrencyTransformer;
use App\Models\Currency;
use App\Models\UserWallet;

class WalletTransformer extends BaseTransformer
{
    protected $defaultIncludes = [
        'currency'
    ];

    public function transform(UserWallet $wallet)
    {
        return [
            'id' => $wallet->id,
            'balance' => (int) $wallet->balance
        ];
    }

    public function includeCurrency(UserWallet $wallet)
    {
        $currency = Currency::find($wallet->currency_id);
        return $this->item($currency, new CurrencyTransformer);
    }
}
