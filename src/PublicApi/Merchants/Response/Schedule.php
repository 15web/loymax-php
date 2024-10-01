<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\Merchants\Response;

/**
 * График работы в указанный день
 */
final readonly class Schedule
{
    /**
     * @param non-empty-string $from
     * @param non-empty-string $to
     */
    public function __construct(
        public string $from,
        public string $to,
    ) {}
}
