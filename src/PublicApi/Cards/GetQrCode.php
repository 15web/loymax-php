<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\Cards;

use Studio15\Loymax\ApiClient\ApiClient;
use Studio15\Loymax\ApiClient\CreateSerializer;
use Studio15\Loymax\ApiClient\Data\Method;
use Studio15\Loymax\ApiClient\Exception\ApiClientException;
use Studio15\Loymax\PublicApi\Cards\Response\QrCode;
use Webmozart\Assert\Assert;

/**
 * Генерирует QR-код для карты по ее внутреннему идентификатору
 *
 * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/Cards/#H41343543D435440438440443435442A0QR-43A43E434A043443B44F43A43044044244B43F43E43543543243D44344244043543D43D43543C44343843443543D44243844443843A43044243E440443
 */
final readonly class GetQrCode
{
    public function __construct(
        private ApiClient $apiClient,
    ) {}

    /**
     * @param positive-int $cardId Внутренний идентификатор карты
     *
     * @throws ApiClientException
     */
    public function __invoke(int $cardId): QrCode
    {
        Assert::positiveInteger($cardId);

        $apiResponse = $this->apiClient->sendRequest(
            method: Method::GET,
            uri: "/publicapi/v1.2/Cards/{$cardId}/QrCode",
        );

        /** @var QrCode $getQrCode */
        $getQrCode = (new CreateSerializer())()->denormalize(
            data: $apiResponse->data ?? [],
            type: QrCode::class,
        );

        return $getQrCode;
    }
}
