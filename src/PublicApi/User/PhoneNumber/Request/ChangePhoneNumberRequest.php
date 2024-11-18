<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\User\PhoneNumber\Request;

use Symfony\Component\Serializer\Attribute\SerializedName;
use Webmozart\Assert\Assert;

/**
 * Запрос на привязку номера телефона
 *
 * @internal
 */
final readonly class ChangePhoneNumberRequest
{
    private const PHONE_NUMBER_REGEX = '/^7\d{10}$/';

    /**
     * @param non-empty-string $phoneNumber Номер телефона клиента
     */
    public function __construct(
        #[SerializedName('phoneNumber')]
        public string $phoneNumber,
    ) {
        Assert::regex($this->phoneNumber, self::PHONE_NUMBER_REGEX);
    }
}
