<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\User;

use Studio15\Loymax\ApiClient\ApiClient;
use Studio15\Loymax\ApiClient\CreateSerializer;
use Studio15\Loymax\ApiClient\Data\Method;
use Studio15\Loymax\ApiClient\Exception\ApiClientException;
use Studio15\Loymax\PublicApi\User\Response\RegistrationActionList;

/**
 * Получение списка необходимых шагов регистрации
 *
 * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/User/#03
 */
final readonly class GetRegistrationActions
{
    public function __construct(
        private ApiClient $apiClient,
    ) {}

    /**
     * @throws ApiClientException
     */
    public function __invoke(): RegistrationActionList
    {
        $apiResponse = $this->apiClient->sendRequest(
            method: Method::GET,
            uri: '/publicapi/v1.2/User/RegistrationActions',
        );

        /** @var RegistrationActionList $registrationActionList */
        $registrationActionList = (new CreateSerializer())()->denormalize(
            data: $apiResponse->data ?? [],
            type: RegistrationActionList::class,
        );

        return $registrationActionList;
    }
}
