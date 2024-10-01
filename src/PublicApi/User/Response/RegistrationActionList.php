<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\User\Response;

/**
 * Список обязательных шагов регистрации
 */
final readonly class RegistrationActionList
{
    /**
     * @param array<RegistrationAction> $actions Шаги регистрации
     */
    public function __construct(
        public array $actions,
    ) {}

    /**
     * Подтверждена ли подписка
     */
    public function isSubscriptionsConfirmed(): bool
    {
        $actionDataList = array_filter(
            array: $this->actions,
            callback: static fn (RegistrationAction $data): bool => $data->userActionType === 'AcceptSubscriptionsConfirm',
        );

        if ($actionDataList === []) {
            return false;
        }

        return reset($actionDataList)->isDone;
    }
}
