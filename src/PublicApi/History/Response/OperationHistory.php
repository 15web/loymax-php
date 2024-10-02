<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\History\Response;

/**
 * @api
 * Ответ с историей операций
 */
final readonly class OperationHistory
{
    /**
     * @param positive-int $allCount Количество записей
     * @param list<Operation> $rows Записи истории
     */
    public function __construct(
        public int $allCount,
        public array $rows
    ) {}
}
