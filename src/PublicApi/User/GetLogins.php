<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\User;

use Studio15\Loymax\ApiClient\ApiClient;
use Studio15\Loymax\ApiClient\CreateRequest;
use Studio15\Loymax\ApiClient\CreateSerializer;
use Studio15\Loymax\ApiClient\Data\Method;
use Studio15\Loymax\PublicApi\Exception\DenormalizeResponseError;
use Studio15\Loymax\PublicApi\User\Response\Logins;
use Throwable;

/**
 * Получение списка логинов пользователя
 *
 * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/User/#02
 *
 * @internal
 */
final readonly class GetLogins
{
    public function __construct(
        private ApiClient $apiClient,
    ) {}

    /**
     * @throws DenormalizeResponseError
     */
    public function __invoke(): Logins
    {
        $apiRequest = (new CreateRequest())(
            method: Method::GET,
            uri: '/publicapi/v1.2/User/Logins',
        );

        $apiResponse = $this->apiClient->sendRequest($apiRequest);

        try {
            /** @var Logins $logins */
            $logins = (new CreateSerializer())()->denormalize(
                data: $apiResponse->data ?? [],
                type: Logins::class,
            );
        } catch (Throwable $e) {
            throw new DenormalizeResponseError(previous: $e);
        }

        return $logins;
    }
}
