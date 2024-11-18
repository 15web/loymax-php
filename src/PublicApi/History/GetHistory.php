<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\History;

use Studio15\Loymax\ApiClient\ApiClient;
use Studio15\Loymax\ApiClient\CreateSerializer;
use Studio15\Loymax\ApiClient\Data\Method;
use Studio15\Loymax\ApiClient\Exception\ApiClientException;
use Studio15\Loymax\PublicApi\History\Request\GetHistoryRequest;
use Studio15\Loymax\PublicApi\History\Response\OperationHistory;

/**
 * Возвращает историю операций клиента
 *
 * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/History/#H41243E43743244043044943043544243844144243E44043844E43E43F43544043044643843943A43B43843543D442430
 */
final readonly class GetHistory
{
    public function __construct(
        private ApiClient $apiClient,
    ) {}

    /**
     * @throws ApiClientException
     */
    public function __invoke(GetHistoryRequest $parameters): OperationHistory
    {
        $apiResponse = $this->apiClient->sendRequest(
            method: Method::GET,
            uri: '/publicapi/v1.2/History',
            parameters: $parameters,
        );

        /** @var OperationHistory $operationHistory */
        $operationHistory = (new CreateSerializer())()->denormalize(
            data: $apiResponse->data ?? [],
            type: OperationHistory::class,
        );

        return $operationHistory;
    }
}
