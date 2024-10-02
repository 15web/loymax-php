<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\User\PhoneNumber\Response;

/**
 * @api
 * Результат запроса на подтверждение номера
 */
final readonly class PhoneNumberState
{
    /**
     * @param string $currentPhoneNumber Текущий номер телефона
     * @param PhoneNumber|null $newPhoneNumber Новый номер телефона
     * @param positive-int $confirmCodeLength Количество символов в коде подтверждения
     */
    public function __construct(
        public string $currentPhoneNumber,
        public ?PhoneNumber $newPhoneNumber,
        public int $confirmCodeLength,
    ) {}
}
