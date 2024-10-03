<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\User\PhoneNumber\Response;

/**
 * @api
 * Номер телефона
 */
final readonly class PhoneNumber
{
    /**
     * @param non-empty-string $phoneNumber Номер телефона
     */
    public function __construct(
        public string $phoneNumber,
    ) {}
}
