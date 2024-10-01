<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\Registration\Response;

/**
 * Невыполненное действие клиента при регистрации
 */
final readonly class UncompletedAction
{
    /**
     * @param non-empty-string $userActionType Вид действия
     * @param non-empty-string $actionState Состояние действия
     * @param bool $isDone Является ли действие выполненным
     */
    public function __construct(
        public string $userActionType,
        public string $actionState,
        public bool $isDone,
    ) {}
}
