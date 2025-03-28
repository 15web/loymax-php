<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\User\Request;

/**
 * Тип операции
 */
enum DetailedBalanceOperationType: string
{
    /**
     * Операции активации
     */
    case BonusActivation = 'BonusActivation';

    /**
     * Операции сгорания
     */
    case BonusExpiration = 'BonusExpiration';
}
