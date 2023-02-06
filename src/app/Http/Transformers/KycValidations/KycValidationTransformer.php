<?php
namespace App\Http\Transformers\KycValidations;

use App\Http\Transformers\BaseTransformer;
use App\Http\Transformers\Constants\ConstantTransformer;
use App\Http\Transformers\Users\UserTransformer;
use App\Models\KycValidation;

class KycValidationTransformer extends BaseTransformer
{
    protected $defaultIncludes = [
        'user', 'status'
    ];

    protected $availableIncludes = [
        'reviewer', 'document'
    ];

    public function transform(KycValidation $validation)
    {
        return [
            'id' => $validation->id,
            'review_notes' => $validation->review_notes,
            'reviewed_at' => $validation->reviewed_at
        ];
    }

    public function includeUser(KycValidation $validation)
    {
        return $this->item($validation->user, new UserTransformer);
    }

    public function includeReviewer(KycValidation $validation)
    {
        if ($validation->reviewer) {
            return $this->item($validation->reviewer, new UserTransformer);
        }
    }

    public function includeStatus(KycValidation $validation)
    {
        $item = [
            'id' => $validation->status,
            'name' => data_get(KycValidation::statuses(), $validation->status)
        ];

        return $this->item($item, new ConstantTransformer);
    }

    public function includeDocument(KycValidation $validation)
    {
        if ($validation->document) {
            return $this->item($validation->document, new KycValidationDocumentTransformer);
        }
    }
}
