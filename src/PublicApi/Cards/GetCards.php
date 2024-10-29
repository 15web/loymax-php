<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\Cards;

use Studio15\Loymax\ApiClient\ApiClient;
use Studio15\Loymax\ApiClient\CreateRequest;
use Studio15\Loymax\ApiClient\CreateSerializer;
use Studio15\Loymax\ApiClient\Data\Method;
use Studio15\Loymax\ApiClient\Exception\ApiClientException;
use Studio15\Loymax\PublicApi\Cards\Response\Card;

/**
 * Возвращает список карт текущего клиента и все операции по ним
 *
 * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/Cards/#H41243E43743244043044943043544244143F43844143E43A43A43044044244243543A44344943543343E43A43B43843543D44243043843244143543E43F43544043044643843843F43E43D43843C
 */
final readonly class GetCards
{
    public function __construct(
        private ApiClient $apiClient,
    ) {}

    /**
     * @return list<Card>
     *
     * @throws ApiClientException
     */
    public function __invoke(): array
    {
        $apiRequest = (new CreateRequest())(
            method: Method::GET,
            uri: '/publicapi/v1.2/Cards',
        );

        $apiResponse = $this->apiClient->sendRequest($apiRequest);

        /** @var list<Card> $cardList */
        $cardList = (new CreateSerializer())()->denormalize(
            data: $apiResponse->data ?? [],
            type: Card::class.'[]',
        );

        return $cardList;
    }
}
