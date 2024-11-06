<?php

declare(strict_types=1);

namespace Studio15\Loymax;

use Studio15\Loymax\ApiClient\ApiClient;
use Studio15\Loymax\PublicApi\Cards;
use Studio15\Loymax\PublicApi\History;
use Studio15\Loymax\PublicApi\Merchants;
use Studio15\Loymax\PublicApi\Notification;
use Studio15\Loymax\PublicApi\Offer;
use Studio15\Loymax\PublicApi\Password;
use Studio15\Loymax\PublicApi\Pushes;
use Studio15\Loymax\PublicApi\Registration;
use Studio15\Loymax\PublicApi\User;

/**
 * @api
 * Методы публичного API
 *
 * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/
 */
final readonly class PublicApiRegistry
{
    public function __construct(
        private ApiClient $apiClient,
    ) {}

    /**
     * Cards. Методы для работы с картами
     *
     * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/Cards/
     */
    public function cards(): Cards
    {
        return new Cards(
            apiClient: $this->apiClient,
        );
    }

    /**
     * History. Методы для работы с историческими данными
     *
     * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/History/
     */
    public function history(): History
    {
        return new History(
            apiClient: $this->apiClient,
        );
    }

    /**
     * Merchants. Методы для работы с торговыми точками
     *
     * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/Merchants/
     */
    public function merchants(): Merchants
    {
        return new Merchants(
            apiClient: $this->apiClient,
        );
    }

    /**
     * PushNotification. Методы для работы с push-уведомлениями
     *
     * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/Pushes/
     */
    public function pushes(): Pushes
    {
        return new Pushes(
            apiClient: $this->apiClient,
        );
    }

    /**
     * Registration. Методы для работы с регистрацией клиентов
     *
     * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/registration/
     */
    public function registration(): Registration
    {
        return new Registration(
            apiClient: $this->apiClient,
        );
    }

    /**
     * Notification. Методы для работы с уведомлениями
     *
     * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/Notification/
     */
    public function notification(): Notification
    {
        return new Notification(
            apiClient: $this->apiClient,
        );
    }

    /**
     * Offer. Методы для работы с таргетированным контентом
     *
     * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/Offer/
     */
    public function offer(): Offer
    {
        return new Offer(
            apiClient: $this->apiClient,
        );
    }

    /**
     * User. Методы для работы с клиентами
     *
     * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/User/
     */
    public function user(): User
    {
        return new User(
            apiClient: $this->apiClient,
        );
    }

    /**
     * Password. Методы для работы с паролем
     *
     * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/Password/
     */
    public function password(): Password
    {
        return new Password(
            apiClient: $this->apiClient,
        );
    }
}
