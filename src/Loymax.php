<?php

declare(strict_types=1);

namespace Studio15\Loymax;

use Psr\Http\Client\ClientInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Studio15\Loymax\ApiClient\ApiClient;
use Studio15\Loymax\ApiClient\GuzzleHttpClientFactory;
use Studio15\Loymax\Modules\CommunicationService;
use Webmozart\Assert\Assert;

/**
 * API Loymax
 */
final readonly class Loymax
{
    private ClientInterface $httpClient;

    /**
     * Конструктор используется для передачи логгера, http-клиента
     * Требуется указать $httpClient либо $baseUri
     *
     * @param ClientInterface|null $httpClient Http-клиент, например Guzzle
     * @param non-empty-string|null $baseUri Полный адрес до API Loymax, например https://mycompany-stg.loymax.tech
     * @param LoggerInterface $logger Логгер, например Monolog
     */
    public function __construct(
        ?ClientInterface $httpClient = null,
        ?string $baseUri = null,
        private LoggerInterface $logger = new NullLogger(),
    ) {
        if ($httpClient === null) {
            Assert::notEmpty($baseUri);
        }

        /** @var non-empty-string $baseUri */
        $this->httpClient = $httpClient ?? GuzzleHttpClientFactory::create(
            baseUri: $baseUri,
        );
    }

    /**
     * Конструктор с настройками по умолчанию
     */
    public static function create(string $baseUri): self
    {
        Assert::notEmpty($baseUri);

        return new self(
            baseUri: $baseUri,
        );
    }

    /**
     * Методы публичного API
     *
     * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/
     *
     * @param non-empty-string|null $token Токен авторизации Участника ПЛ
     */
    public function publicApi(?string $token = null): PublicApiRegistry
    {
        $apiClient = new ApiClient(
            httpClient: $this->httpClient,
            logger: $this->logger,
            token: $token,
        );

        return new PublicApiRegistry(
            apiClient: $apiClient,
        );
    }

    /**
     * Авторизационный сервис
     *
     * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/Authorization_Service/
     */
    public function authApi(): AuthorizationService
    {
        $apiClient = new ApiClient(
            httpClient: $this->httpClient,
            logger: $this->logger,
        );

        return new AuthorizationService(
            apiClient: $apiClient,
        );
    }

    /**
     * CommunicationService. Персональные предложения с использованием механик Machine Learning
     *
     * @see https://docs.loymax.net/xwiki/bin/view/Main/Installation_and_configuration/Extra_modules/CommunicationService_ML/
     *
     * @param non-empty-string $token Токен авторизации Участника ПЛ
     */
    public function communicationService(string $token): CommunicationService
    {
        $apiClient = new ApiClient(
            httpClient: $this->httpClient,
            logger: $this->logger,
            token: $token,
        );

        return new CommunicationService(
            apiClient: $apiClient,
        );
    }
}
