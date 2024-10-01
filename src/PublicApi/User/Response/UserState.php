<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\User\Response;

/**
 * Состояние клиента
 *
 * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/User/#01
 */
enum UserState: string
{
    /**
     * Не зарегистрирован
     */
    case Normal = 'Normal';

    /**
     * Зарегистрирован
     */
    case Registered = 'Registered';

    /**
     * Anonymous
     */
    case Anonymous = 'Anonymous';

    /**
     * Удален
     */
    case Deleted = 'Deleted';

    /**
     * Отказался от участия в ПЛ
     */
    case Deregistered = 'Deregistered';
}
