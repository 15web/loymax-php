<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\User\Email;

use Studio15\Loymax\ApiClient\ApiClient;
use Studio15\Loymax\ApiClient\CreateRequest;
use Studio15\Loymax\ApiClient\CreateSerializer;
use Studio15\Loymax\ApiClient\Data\Method;
use Studio15\Loymax\ApiClient\Exception\ApiClientException;
use Studio15\Loymax\PublicApi\User\Email\Response\Email;

/**
 * Возвращает текущий статус email клиента
 *
 * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/Email/?srid=NJuz5jjt#H41243E43743244043044943043544244243543A443449438439441442430442443441email43A43B43843543D442430
 */
final readonly class GetEmail
{
    public function __construct(
        private ApiClient $apiClient,
    ) {}

    /**
     * @throws ApiClientException
     */
    public function __invoke(): Email
    {
        $request = (new CreateRequest())(
            method: Method::GET,
            uri: '/publicapi/v1.2/User/Email',
        );

        $response = $this->apiClient->sendRequest($request);

        /** @var Email $email */
        $email = (new CreateSerializer())()->denormalize(
            data: $response->data,
            type: Email::class,
        );

        return $email;
    }
}
