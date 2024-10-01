<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\User;

use Studio15\Loymax\ApiClient\ApiClient;
use Studio15\Loymax\ApiClient\CreateRequest;
use Studio15\Loymax\ApiClient\CreateSerializer;
use Studio15\Loymax\ApiClient\Data\Method;
use Studio15\Loymax\PublicApi\Exception\DenormalizeResponseError;
use Studio15\Loymax\PublicApi\User\Response\StatusSystem;
use Throwable;

/**
 * Возвращает клиенту подробную информацию о его статусах в статусных системах
 *
 * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/User/Status/#H41243E43743244043044943043544243A43B43843543D44244343F43E43444043E43143D44344E43843D44443E44043C43044643844E43E43543343E44144243044244344143044543244144243044244344143D44B44544143844144243543C430445
 */
final readonly class GetStatus
{
    public function __construct(
        private ApiClient $apiClient,
    ) {}

    /**
     * @return list<StatusSystem>
     *
     * @throws DenormalizeResponseError
     */
    public function __invoke(): array
    {
        $apiRequest = (new CreateRequest())(
            method: Method::GET,
            uri: '/publicapi/v1.2/User/Status',
        );

        $apiResponse = $this->apiClient->sendRequest($apiRequest);

        try {
            /** @var list<StatusSystem> $statusSystemList */
            $statusSystemList = (new CreateSerializer())()->denormalize(
                data: $apiResponse->data ?? [],
                type: StatusSystem::class.'[]',
            );
        } catch (Throwable $e) {
            throw new DenormalizeResponseError(previous: $e);
        }

        return $statusSystemList;
    }
}
