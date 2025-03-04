<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\Pushes\Request;

/**
 * Сервис уведомлений
 */
enum PushServiceType: string
{
    /**
     * Android
     */
    case FCM = 'Fcm';

    /**
     * IOS
     */
    case APNS = 'Apns';

    /**
     * Harmony
     */
    case HMC = 'HMS';
}
