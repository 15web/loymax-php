<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\User\Email\Response;

/**
 * @api
 * Текущий статус email клиента
 */
final readonly class Email
{
    /**
     * @param non-empty-string|null $currentEmail Текущий Email
     * @param NewEmail $newEmail Новый (неподтвержденный) Email
     * @param non-negative-int $confirmCodeLength Длина кода подтверждения
     * @param NotifierStatus $currentNotifierStatus Текущее состояние нотификатора
     * @param non-empty-string|null $notifierMask
     */
    public function __construct(
        public ?string $currentEmail,
        public NewEmail $newEmail,
        public int $confirmCodeLength,
        public NotifierStatus $currentNotifierStatus,
        public ?string $notifierMask,
    ) {}
}
