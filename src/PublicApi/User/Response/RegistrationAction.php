<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\User\Response;

/**
 * Шаг регистрации
 */
final readonly class RegistrationAction
{
    /**
     * @param non-empty-string $userActionType Наименование шага
     * @param RegistrationActionState $actionState Статус шага
     * @param bool $isDone Статус выполнения
     */
    public function __construct(
        public string $userActionType,
        public RegistrationActionState $actionState,
        public bool $isDone,
    ) {}
}
