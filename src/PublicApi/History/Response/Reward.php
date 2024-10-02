<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\History\Response;

/**
 * @api
 * Начисление
 */
final readonly class Reward
{
    /**
     * @param Amount $amount Сумма
     */
    public function __construct(
        public Amount $amount
    ) {}
}
