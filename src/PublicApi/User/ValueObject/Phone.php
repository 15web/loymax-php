<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\User\ValueObject;

use Webmozart\Assert\Assert;

/**
 * Номер телефона
 *
 * @internal
 */
final readonly class Phone
{
    private const PHONE_NUMBER_REGEX = '/^7\d{10}$/';

    /**
     * @param non-empty-string $value
     */
    public function __construct(
        public string $value
    ) {
        Assert::regex(
            value: $value,
            pattern: self::PHONE_NUMBER_REGEX,
        );
    }
}
