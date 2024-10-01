<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\History\Response;

/**
 * Списание
 */
final readonly class Withdraw
{
    /**
     * @param Amount $amount Сумма
     */
    public function __construct(
        public Amount $amount
    ) {}
}
