<?php

declare(strict_types=1);

namespace Studio15\Loymax\ApiClient\Response;

/**
 * Статус ответа от API
 *
 * @internal
 */
enum State: string
{
    /**
     * Успешный ответ
     */
    case SUCCESS = 'Success';

    /**
     * Произошла ошибка
     */
    case ERROR = 'Error';

    /**
     * Ошибка валидации
     */
    case VALIDATION_ERROR = 'ValidationError';

    /**
     * Системная ошибка на стороне процессинга
     */
    case FAIL = 'Fail';
}
