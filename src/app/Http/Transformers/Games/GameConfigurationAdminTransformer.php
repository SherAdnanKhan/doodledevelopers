<?php


namespace App\Http\Transformers\Games;

use App\Http\Transformers\BaseTransformer;
use App\Models\GameConfiguration;

class GameConfigurationAdminTransformer extends BaseTransformer
{

    public function transform(GameConfiguration $configuration)
    {
        return [
            'id' => $configuration->id,
            'currency_conversion_duration' => $configuration->currency_conversion_duration,
            'min_deposit_amount' => $configuration->min_deposit_amount,
            'max_deposit_amount' => $configuration->max_deposit_amount,
            'min_withdrawal_amount' => $configuration->min_withdrawal_amount,
            'max_withdrawal_amount' => $configuration->max_withdrawal_amount,
            'amount_of_balls_to_fire' => $configuration->amount_of_balls_to_fire,
            'total_attempts' => $configuration->total_attempts,
            'maintenance_mode' => $configuration->maintenance_mode,
            'created_at' => $configuration->created_at,
            'updated_at' => $configuration->updated_at
        ];
    }
}
