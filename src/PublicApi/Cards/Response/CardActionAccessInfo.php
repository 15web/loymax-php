<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\Cards\Response;

/**
 * @api
 * Информация о возможности выполнять действия с картой
 */
final readonly class CardActionAccessInfo
{
    /**
     * @param bool $canBlock Возможность заблокировать карту
     * @param bool $canReplace Возможность заменить карту
     */
    public function __construct(
        public bool $canBlock,
        public bool $canReplace,
    ) {}
}
