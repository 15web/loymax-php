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
    /**
     * @param numeric-string $value
     */
    public function __construct(public string $value)
    {
        Assert::numeric($value);
    }
}
