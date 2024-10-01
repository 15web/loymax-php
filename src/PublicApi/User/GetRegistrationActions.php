<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\User;

use Studio15\Loymax\ApiClient\ApiClient;
use Studio15\Loymax\ApiClient\CreateRequest;
use Studio15\Loymax\ApiClient\CreateSerializer;
use Studio15\Loymax\ApiClient\Data\Method;
use Studio15\Loymax\PublicApi\Exception\DenormalizeResponseError;
use Studio15\Loymax\PublicApi\User\Response\RegistrationActionList;
use Throwable;

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
     * @throws DenormalizeResponseError
     */
    public function __invoke(): RegistrationActionList
    {
        $apiRequest = (new CreateRequest())(
            method: Method::GET,
            uri: '/publicapi/v1.2/User/RegistrationActions',
        );

        $apiResponse = $this->apiClient->sendRequest($apiRequest);

        try {
            /** @var RegistrationActionList $registrationActionList */
            $registrationActionList = (new CreateSerializer())()->denormalize(
                data: $apiResponse->data ?? [],
                type: RegistrationActionList::class,
            );
        } catch (Throwable $e) {
            throw new DenormalizeResponseError(previous: $e);
        }

        return $registrationActionList;
    }
}
