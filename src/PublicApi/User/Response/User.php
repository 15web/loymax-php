<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\User\Response;

use DateTimeImmutable;

/**
 * @api
 * Информация о текущем авторизованном клиенте
 */
final readonly class User
{
    /**
     * @param positive-int $id Идентификатор пользователя
     * @param non-empty-string $personUid Уникальный идентификатор пользователя
     * @param non-empty-string|null $firstName Имя
     * @param non-empty-string|null $lastName Фамилия
     * @param non-empty-string|null $patronymicName Отчество
     * @param non-empty-string|null $birthDay День рождения
     * @param UserState $state Состояние клиента
     * @param non-empty-string|null $phoneNumber Номер телефона, частично скрытый - "***1234"
     * @param non-empty-string|null $email Email
     * @param BalanceShortInfo|null $balanceShortInfo Баланс клиента
     * @param array<string, ?Attribute>|null $attributes Атрибуты клиента, ключи массива - имена полей
     */
    public function __construct(
        public int $id,
        public string $personUid,
        public ?string $lastName,
        public ?string $firstName,
        public ?string $patronymicName,
        public ?string $birthDay,
        public UserState $state,
        public ?string $phoneNumber = null,
        public ?string $email = null,
        public ?BalanceShortInfo $balanceShortInfo = null,
        public ?array $attributes = null,
    ) {}

    /**
     * @param non-empty-string $attributeValue
     */
    public function getAttributeValue(string $attributeValue): null|DateTimeImmutable|string
    {
        if ($this->attributes === null) {
            return null;
        }

        $attributeName = str_replace('Attributes.', '', $attributeValue);

        if (!\array_key_exists($attributeName, $this->attributes)) {
            return null;
        }

        $attribute = $this->attributes[$attributeName];

        if ($attribute === null) {
            return null;
        }

        return match ($attribute->type) {
            AttributeType::FixedAnswers => implode(',', $attribute->answers ?? []),
            AttributeType::DateValue => $attribute->dateValue,
            default => $attribute->stringValue,
        };
    }

    /**
     * @return non-empty-string|null
     */
    public function fullName(): ?string
    {
        $nameParts = array_filter(
            array: [$this->lastName, $this->firstName, $this->patronymicName],
            callback: static fn (?string $name): bool => $name !== null,
        );

        if ($nameParts === []) {
            return null;
        }

        return implode(' ', $nameParts);
    }
}
