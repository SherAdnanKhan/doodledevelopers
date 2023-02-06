<?php
namespace App\Http\Transformers\KycValidations;

use App\Http\Transformers\BaseTransformer;
use App\Http\Transformers\Constants\ConstantTransformer;
use App\Models\KycValidationDocument;

class KycValidationDocumentTransformer extends BaseTransformer
{
    protected $defaultIncludes = [
        'type'
    ];

    public function transform(KycValidationDocument $document)
    {
        return [
            'id' => $document->id,
            'filename' => $document->filename,
            'link' => asset("storage/$document->link"),
            'type' => $document->type
        ];
    }

    public function includeType(KycValidationDocument $document)
    {
        $item = [
            'id' => $document->type,
            'name' => data_get(KycValidationDocument::types(), $document->type)
        ];

        return $this->item($item, new ConstantTransformer);
    }

}
