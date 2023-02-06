<?php
namespace App\Http\Transformers\Constants;

use App\Http\Transformers\BaseTransformer;
use App\Models\Country;
use App\Models\Currency;
use App\Models\Deposit;
use App\Models\Game;
use App\Models\GamePlayer;
use App\Models\GameTransaction;
use App\Models\GameWinnerEarnings;
use App\Models\HearAboutUsPlatform;
use App\Models\KycValidation;
use App\Models\KycValidationDocument;
use App\Models\PaymentMethod;
use App\Models\SupportTicket;
use App\Models\User;
use App\Models\UserTransaction;
use App\Models\WalletTransaction;
use App\Models\Withdrawal;

class ConstantsTransformer extends BaseTransformer
{
    protected $defaultIncludes = [
        'userStatuses',
        'kycValidationStatuses',
        'kycValidationDocumentTypes',
        'gameStatuses',
        'gameWinnerEarningStatuses',
        'gamePlayerStatuses',
        'currencyTypes',
        'depositStatuses',
        'withdrawalStatuses',
        'userTransactionStatuses',
        'paymentMethodTypes',
        'walletTransactionTypes',
        'gameTransactionStatuses',
        'ticketStatuses',
        'countries',
        'hearAboutUsPlatforms'
    ];

    public function transform($constants)
    {
        return [

        ];
    }

    public function includeUserStatuses()
    {
        $userStatuses = [];
        foreach (User::statuses() as $id => $name) {
            $userStatuses[] = ['id' => $id, 'name' => $name];
        }
        return $this->collection($userStatuses, new ConstantTransformer);
    }

    public function includeKycValidationStatuses()
    {
        $kycValidationStatuses = [];
        foreach (KycValidation::statuses() as $id => $name) {
            $kycValidationStatuses[] = ['id' => $id, 'name' => $name];
        }
        return $this->collection($kycValidationStatuses, new ConstantTransformer);
    }

    public function includeKycValidationDocumentTypes()
    {
        $kycValidationDocumentTypes = [];
        foreach (KycValidationDocument::types() as $id => $name) {
            $kycValidationDocumentTypes[] = ['id' => $id, 'name' => $name];
        }
        return $this->collection($kycValidationDocumentTypes, new ConstantTransformer);
    }

    public function includeGameStatuses()
    {
        $gameStatuses = [];
        foreach (Game::statuses() as $id => $name) {
            $gameStatuses[] = ['id' => $id, 'name' => $name];
        }
        return $this->collection($gameStatuses, new ConstantTransformer);
    }

    public function includeGameWinnerEarningStatuses()
    {
        $gameWinnerEarningStatuses = [];
        foreach (GameWinnerEarnings::statuses() as $id => $name) {
            $gameWinnerEarningStatuses[] = ['id' => $id, 'name' => $name];
        }
        return $this->collection($gameWinnerEarningStatuses, new ConstantTransformer);
    }

    public function includeGamePlayerStatuses()
    {
        $gamePlayerStatuses = [];
        foreach (GamePlayer::statuses() as $id => $name) {
            $gamePlayerStatuses[] = ['id' => $id, 'name' => $name];
        }
        return $this->collection($gamePlayerStatuses, new ConstantTransformer);
    }

    public function includeCurrencyTypes()
    {
        $currencyTypes = [];
        foreach (Currency::types() as $id => $name) {
            $currencyTypes[] = ['id' => $id, 'name' => $name];
        }
        return $this->collection($currencyTypes, new ConstantTransformer);
    }

    public function includeDepositStatuses()
    {
        $depositStatuses = [];
        foreach (Deposit::statuses() as $id => $name) {
            $depositStatuses[] = ['id' => $id, 'name' => $name];
        }
        return $this->collection($depositStatuses, new ConstantTransformer);
    }

    public function includeWithdrawalStatuses()
    {
        $withdrawalStatuses = [];
        foreach (Withdrawal::statuses() as $id => $name) {
            $withdrawalStatuses[] = ['id' => $id, 'name' => $name];
        }
        return $this->collection($withdrawalStatuses, new ConstantTransformer);
    }

    public function includeUserTransactionStatuses()
    {
        $userTransactionStatuses = [];
        foreach (UserTransaction::statuses() as $id => $name) {
            $userTransactionStatuses[] = ['id' => $id, 'name' => $name];
        }
        return $this->collection($userTransactionStatuses, new ConstantTransformer);
    }

    public function includePaymentMethodTypes()
    {
        $paymentMethods = [];
        foreach (PaymentMethod::all() as $paymentMethod) {
            $paymentMethods[] = ['id' => $paymentMethod['id'], 'name' => $paymentMethod['label']];
        }

        return $this->collection($paymentMethods, new ConstantTransformer);
    }

    public function includeWalletTransactionTypes()
    {
        $walletTransactionTypes = [];
        foreach (WalletTransaction::types() as $id => $name) {
            $walletTransactionTypes[] = ['id' => $id, 'name' => $name];
        }
        return $this->collection($walletTransactionTypes, new ConstantTransformer);
    }

    public function includeGameTransactionTypes()
    {
        $gameTransactionTypes = [];
        foreach (GameTransaction::types() as $id => $name) {
            $gameTransactionTypes[] = ['id' => $id, 'name' => $name];
        }
        return $this->collection($gameTransactionTypes, new ConstantTransformer);
    }

    public function includeGameTransactionStatuses()
    {
        $gameTransactionStatuses = [];
        foreach (GameTransaction::statuses() as $id => $name) {
            $gameTransactionStatuses[] = ['id' => $id, 'name' => $name];
        }
        return $this->collection($gameTransactionStatuses, new ConstantTransformer);
    }

    public function includeTicketStatuses()
    {
        $ticketStatuses = [];
        foreach (SupportTicket::statuses() as $id => $name) {
            $ticketStatuses[] = ['id' => $id, 'name' => $name];
        }
        return $this->collection($ticketStatuses, new ConstantTransformer);
    }

    public function includeCountries()
    {
        $countries = [];
        foreach (Country::all() as $country) {
            $countries[] = ['id' => $country->id, 'name' => $country->label];
        }
        return $this->collection($countries, new ConstantTransformer);
    }

    public function includeHearAboutUsPlatforms()
    {
        $hearAboutUsPlatforms = [];
        foreach (HearAboutUsPlatform::all() as $hearAboutUsPlatform) {
            $hearAboutUsPlatforms[] = ['id' => $hearAboutUsPlatform->id, 'name' => $hearAboutUsPlatform->name];
        }
        return $this->collection($hearAboutUsPlatforms, new ConstantTransformer);
    }
}
