<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\Cards\Response;

use Symfony\Component\Uid\Uuid;

/**
 * @api
 * Информация о владельце карты
 */
final readonly class CardOwnerInfo
{
    /**
     * @param positive-int $id Внутренний идентификатор Участника ПЛ в Системе
     * @param Uuid $personUid Внешний идентификатор Участника ПЛ
     * @param non-empty-string|null $firstName Имя Участника ПЛ
     * @param non-empty-string|null $lastName Фамилия Участника ПЛ
     * @param non-empty-string|null $patronymicName Отчество Участника ПЛ
     * @param non-empty-string|null $phoneNumber Номер телефона в формате «***1234»
     * @param non-empty-string|null $email Email
     */
    public function __construct(
        public int $id,
        public Uuid $personUid,
        public ?string $firstName,
        public ?string $lastName,
        public ?string $patronymicName,
        public ?string $phoneNumber,
        public ?string $email,
    ) {}
}
