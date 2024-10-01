<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\User\Response;

/**
 * Статус шага регистрации
 */
enum RegistrationActionState: string
{
    /**
     * Обязательный
     */
    case REQUIRED = 'Required';

    /**
     * Опциональный
     */
    case CUSTOM = 'Custom';
}
