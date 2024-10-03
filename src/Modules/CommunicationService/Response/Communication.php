<?php

declare(strict_types=1);

namespace Studio15\Loymax\Modules\CommunicationService\Response;

/**
 * @api
 * Персональное предложение
 */
final readonly class Communication
{
    /**
     * @param positive-int $id Внутренний идентификатор персонального предложения
     * @param list<CommunicationValue> $value Информация о товарах в персональном предложении
     */
    public function __construct(
        public int $id,
        public array $value,
    ) {}
}
