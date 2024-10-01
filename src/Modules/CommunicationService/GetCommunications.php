<?php

declare(strict_types=1);

namespace Studio15\Loymax\Modules\CommunicationService;

use Studio15\Loymax\ApiClient\ApiClient;
use Studio15\Loymax\ApiClient\CreateRequest;
use Studio15\Loymax\ApiClient\CreateSerializer;
use Studio15\Loymax\ApiClient\Data\Method;
use Studio15\Loymax\ApiClient\Exception\ApiClientException;
use Studio15\Loymax\Modules\CommunicationService\Response\CommunicationList;
use Studio15\Loymax\PublicApi\Exception\DenormalizeResponseError;
use Throwable;

/**
 * Получение информации о персональном предложении
 *
 * @see https://docs.loymax.net/xwiki/bin/view/Main/Installation_and_configuration/Extra_modules/CommunicationService_ML/#H41F43E43B44344743543D43843543843D44443E44043C43044643843843E43F43544044143E43D43043B44C43D43E43C43F44043543443B43E43643543D438438
 */
final readonly class GetCommunications
{
    public function __construct(
        private ApiClient $apiClient,
    ) {}

    /**
     * @throws ApiClientException
     */
    public function __invoke(): CommunicationList
    {
        $apiRequest = (new CreateRequest())(
            method: Method::POST,
            uri: '/CommunicationService/api/v1/Communication/Communications',
        );

        $apiResponse = $this->apiClient->sendRequest($apiRequest);

        try {
            /** @var CommunicationList $communicationList */
            $communicationList = (new CreateSerializer())()->denormalize(
                data: $apiResponse->data ?? [],
                type: CommunicationList::class,
            );
        } catch (Throwable $e) {
            throw new DenormalizeResponseError(previous: $e);
        }

        return $communicationList;
    }
}
