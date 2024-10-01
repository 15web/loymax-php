<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\Merchants\Response;

/**
 * Дополнительная информация о торговой точке
 */
final readonly class AdditionalInfo
{
    /**
     * @param non-empty-string $name Название параметра
     */
    public function __construct(
        public string $name,
        public mixed $value,
    ) {}
}
