<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\User\PhoneNumber;

use Studio15\Loymax\ApiClient\ApiClient;
use Studio15\Loymax\ApiClient\CreateRequest;
use Studio15\Loymax\ApiClient\CreateSerializer;
use Studio15\Loymax\ApiClient\Data\Method;
use Studio15\Loymax\PublicApi\Exception\DenormalizeResponseError;
use Studio15\Loymax\PublicApi\User\PhoneNumber\Response\PhoneNumberChanged;
use Studio15\Loymax\PublicApi\User\ValueObject\Phone;
use Throwable;

/**
 * Начинает процесс привязки номера телефона
 *
 * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/User/PhoneNumber/#H41D43044743843D43043544243F44043E44643544144143F44043843244F43743A43843D43E43C43544043044243543B43544443E43D430
 */
final readonly class ChangePhoneNumber
{
    public function __construct(
        private ApiClient $apiClient,
    ) {}

    public function __invoke(Phone $phone): PhoneNumberChanged
    {
        $request = (new CreateRequest())(
            method: Method::POST,
            uri: '/publicapi/v1.2/User/PhoneNumber',
            body: [
                'phoneNumber' => $phone->value,
            ],
        );

        $response = $this->apiClient->sendRequest($request);

        try {
            /** @var PhoneNumberChanged $phoneChangedResponse */
            $phoneChangedResponse = (new CreateSerializer())()->denormalize(
                data: $response->data,
                type: PhoneNumberChanged::class,
            );
        } catch (Throwable $t) {
            throw new DenormalizeResponseError(previous: $t);
        }

        return $phoneChangedResponse;
    }
}
