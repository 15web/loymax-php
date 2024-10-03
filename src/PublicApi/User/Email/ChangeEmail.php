<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\User\Email;

use Studio15\Loymax\ApiClient\ApiClient;
use Studio15\Loymax\ApiClient\CreateRequest;
use Studio15\Loymax\ApiClient\CreateSerializer;
use Studio15\Loymax\ApiClient\Data\Method;
use Studio15\Loymax\ApiClient\Exception\ApiClientException;
use Studio15\Loymax\PublicApi\User\Email\Response\EmailChanged;
use Studio15\Loymax\PublicApi\User\ValueObject\Email;

/**
 * Запускает процесс изменения email. Указание нового email
 *
 * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/Email/#H41743043F44344143A43043544243F44043E44643544144143843743C43543D43543D43844FA0email.42343A43043743043D43843543D43E43243E43343Eemail
 */
final readonly class ChangeEmail
{
    public function __construct(
        private ApiClient $apiClient,
    ) {}

    /**
     * @throws ApiClientException
     */
    public function __invoke(Email $email): EmailChanged
    {
        $request = (new CreateRequest())(
            method: Method::POST,
            uri: '/publicapi/v1.2/User/Email',
            body: [
                'email' => $email->value,
            ],
        );

        $response = $this->apiClient->sendRequest($request);

        /** @var EmailChanged $emailChangedResponse */
        $emailChangedResponse = (new CreateSerializer())()->denormalize(
            data: $response->data,
            type: EmailChanged::class,
        );

        return $emailChangedResponse;
    }
}
