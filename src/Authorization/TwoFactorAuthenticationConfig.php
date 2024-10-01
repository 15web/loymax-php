<?php

declare(strict_types=1);

namespace Studio15\Loymax\Authorization;

/**
 * @internal
 */
final readonly class TwoFactorAuthenticationConfig
{
    public const GRANT_TYPE = 'password';

    public const TWO_FACTOR_AUTH_TOKEN = 'X-Loymax-2FA';
}
