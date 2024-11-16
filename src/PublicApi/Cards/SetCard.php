<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\Cards;

use Studio15\Loymax\ApiClient\ApiClient;
use Studio15\Loymax\ApiClient\CreateSerializer;
use Studio15\Loymax\ApiClient\Data\Method;
use Studio15\Loymax\ApiClient\Exception\ApiClientException;
use Studio15\Loymax\PublicApi\Cards\Request\SetCardRequest;
use Studio15\Loymax\PublicApi\Cards\Response\EmittedCard;

/**
 * Прикрепляет карту
 *
 * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/Cards/#H41F44043843A44043543F43B44F43544243A430440442443
 */
final readonly class SetCard
{
    public function __construct(
        private ApiClient $apiClient,
    ) {}

    /**
     * @throws ApiClientException
     */
    public function __invoke(SetCardRequest $requestBody): EmittedCard
    {
        $apiResponse = $this->apiClient->sendRequest(
            method: Method::POST,
            uri: '/publicapi/v1.2/Cards/Set',
            body: $requestBody,
        );

        /** @var EmittedCard $card */
        $card = (new CreateSerializer())()->denormalize(
            data: $apiResponse->data ?? [],
            type: EmittedCard::class,
        );

        return $card;
    }
}
