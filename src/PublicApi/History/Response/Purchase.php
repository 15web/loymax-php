<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\History\Response;

/**
 * Покупка
 */
final readonly class Purchase
{
    /**
     * @param Amount $amount Сумма
     */
    public function __construct(
        public Amount $amount
    ) {}
}
