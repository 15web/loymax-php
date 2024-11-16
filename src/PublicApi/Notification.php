<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi;

use Studio15\Loymax\ApiClient\ApiClient;
use Studio15\Loymax\ApiClient\Exception\ApiClientException;
use Studio15\Loymax\PublicApi\Notification\GetNotification;
use Studio15\Loymax\PublicApi\Notification\GetNotificationCount;
use Studio15\Loymax\PublicApi\Notification\ReadNotification;
use Studio15\Loymax\PublicApi\Notification\ReadNotificationById;
use Studio15\Loymax\PublicApi\Notification\Request\GetNotificationRequest;
use Studio15\Loymax\PublicApi\Notification\Response\Notification as NotificationData;
use Studio15\Loymax\PublicApi\Notification\Response\ReadNotificationCount;
use Studio15\Loymax\PublicApi\Notification\Response\UnreadNotificationCount;

/**
 * Notification. Методы для работы с уведомлениями
 *
 * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/Notification/
 */
final readonly class Notification
{
    public function __construct(
        private ApiClient $apiClient,
    ) {}

    /**
     * Возвращает список оповещений
     *
     * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/Notification/#H41243E43743244043044943043544244143F43844143E43AA043E43F43E43243544943543D438439
     *
     * @param non-negative-int $from Порядковый номер начального элемента выборки
     * @param positive-int $count Количество возвращаемых элементов выборки
     *
     * @return list<NotificationData>
     *
     * @throws ApiClientException
     */
    public function getNotifications(int $from = 0, int $count = 10): array
    {
        $parameters = new GetNotificationRequest(
            from: $from,
            count: $count,
        );

        $getNotifications = new GetNotification(
            apiClient: $this->apiClient,
        );

        return ($getNotifications)(
            parameters: $parameters,
        );
    }

    /**
     * Возвращает количество непрочитанных оповещений
     *
     * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/Notification/#H41243E43743244043044943043544243A43E43B43844743544144243243E43E43F43E43243544943543D438439
     *
     * @throws ApiClientException
     */
    public function getNotificationCount(): UnreadNotificationCount
    {
        $getNotificationCount = new GetNotificationCount(
            apiClient: $this->apiClient,
        );

        return ($getNotificationCount)();
    }

    /**
     * Отмечает оповещение как прочитанное
     *
     * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/Notification/#H41E44243C43544743043544243E43F43E43243544943543D43843543A43043A43F44043E44743844243043D43D43E435
     *
     * @param positive-int $notificationId Id оповещения
     *
     * @throws ApiClientException
     */
    public function readNotificationById(int $notificationId): NotificationData
    {
        $readNotificationById = new ReadNotificationById(
            apiClient: $this->apiClient,
        );

        return ($readNotificationById)($notificationId);
    }

    /**
     * Отмечает все оповещения прочитанными
     * Возвращает количество оповещений, отмеченных как прочитанные
     *
     * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/Notification/#H41E44243C43544743043544243244143543E43F43E43243544943543D43844F43F44043E44743844243043D43D44B43C438
     *
     * @throws ApiClientException
     */
    public function readNotifications(): ReadNotificationCount
    {
        $readNotifications = new ReadNotification(
            apiClient: $this->apiClient,
        );

        return ($readNotifications)();
    }
}
