<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\User\ValueObject;

use Webmozart\Assert\Assert;

/**
 * Email
 *
 * @internal
 */
final readonly class Email
{
    /**
     * @param non-empty-string $value
     */
    public function __construct(
        public string $value,
    ) {
        Assert::email($value);
    }
}
