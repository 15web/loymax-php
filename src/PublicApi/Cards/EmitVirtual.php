<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\Cards;

use Studio15\Loymax\ApiClient\ApiClient;
use Studio15\Loymax\ApiClient\CreateSerializer;
use Studio15\Loymax\ApiClient\Data\Method;
use Studio15\Loymax\ApiClient\Exception\ApiClientException;
use Studio15\Loymax\PublicApi\Cards\Response\EmittedCard;

/**
 * Выпускает виртуальную карту
 *
 * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/Cards/#H41244B43F44344143A43043544243243844044244343043B44C43D44344EA043A430440442443
 */
final readonly class EmitVirtual
{
    public function __construct(
        private ApiClient $apiClient,
    ) {}

    /**
     * @throws ApiClientException
     */
    public function __invoke(): EmittedCard
    {
        $apiResponse = $this->apiClient->sendRequest(
            method: Method::PUT,
            uri: '/publicapi/v1.2/Cards/EmitVirtual',
        );

        /** @var EmittedCard $card */
        $card = (new CreateSerializer())()->denormalize(
            data: $apiResponse->data ?? [],
            type: EmittedCard::class,
        );

        return $card;
    }
}
