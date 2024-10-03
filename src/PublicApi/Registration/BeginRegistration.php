<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\Registration;

use Studio15\Loymax\ApiClient\ApiClient;
use Studio15\Loymax\ApiClient\CreateRequest;
use Studio15\Loymax\ApiClient\CreateSerializer;
use Studio15\Loymax\ApiClient\Data\Method;
use Studio15\Loymax\ApiClient\Exception\ApiClientException;
use Studio15\Loymax\ApiClient\Exception\InvalidResponse;
use Studio15\Loymax\PublicApi\Registration\Exception\RegistrationAlreadyCompleted;
use Studio15\Loymax\PublicApi\Registration\Exception\RegistrationBlocked;
use Studio15\Loymax\PublicApi\Registration\Request\BeginRegistrationRequest;
use Studio15\Loymax\PublicApi\Registration\Response\BeginRegistrationResponse;

/**
 * Запускает регистрацию клиента
 *
 * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/registration/#H41743043F44344143A43043544244043543343844144244043044643844EA043A43B43843543D442430
 */
final readonly class BeginRegistration
{
    private const RegistrationBlockedState = 'RegistrationBlocked';

    private const RegistrationAlreadyCompletedState = 'RegistrationAlreadyCompleted';

    public function __construct(
        private ApiClient $apiClient,
    ) {}

    /**
     * @throws RegistrationAlreadyCompleted
     * @throws RegistrationBlocked
     * @throws ApiClientException
     * @throws InvalidResponse
     */
    public function __invoke(BeginRegistrationRequest $request): BeginRegistrationResponse
    {
        $headers = [];

        if ($request->clientIp !== null) {
            $headers['X-Forwarded-For'] = $request->clientIp;
        }

        $apiRequest = (new CreateRequest())(
            method: Method::POST,
            uri: '/publicapi/v1.2/Registration/BeginRegistration',
            headers: $headers,
            body: [
                'login' => $request->login,
                'password' => $request->password,
            ],
        );

        try {
            $apiResponse = $this->apiClient->sendRequest($apiRequest);
        } catch (InvalidResponse $exception) {
            $this->validateBeginRegistrationState($exception);
        }

        /** @var BeginRegistrationResponse $beginRegistration */
        $beginRegistration = (new CreateSerializer())()->denormalize(
            data: $apiResponse->data ?? [],
            type: BeginRegistrationResponse::class,
        );

        return $beginRegistration;
    }

    /**
     * @throws RegistrationAlreadyCompleted
     * @throws RegistrationBlocked
     * @throws InvalidResponse
     */
    private function validateBeginRegistrationState(InvalidResponse $exception): void
    {
        /**
         * @var array{
         *     state?: non-empty-string,
         *     errorMessage?: non-empty-string
         * } $data
         */
        $data = $exception->data ?? [];

        if (!\array_key_exists('state', $data)) {
            throw $exception;
        }

        $errorMessage = '';

        if (\array_key_exists('errorMessage', $data)) {
            $errorMessage = $data['errorMessage'];
        }

        throw match ($data['state']) {
            self::RegistrationAlreadyCompletedState => new RegistrationAlreadyCompleted($errorMessage),
            self::RegistrationBlockedState => new RegistrationBlocked($errorMessage),
            default => $exception,
        };
    }
}
