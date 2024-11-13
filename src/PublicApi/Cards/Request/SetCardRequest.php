<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\Cards\Request;

use Webmozart\Assert\Assert;

/**
 * Запрос на прикрепление карты
 *
 * @internal
 */
final readonly class SetCardRequest
{
    /**
     * @param non-empty-string $cardNumber Номер карты
     * @param non-empty-string|null $cvcCode CVC-код
     */
    public function __construct(
        public string $cardNumber,
        public ?string $cvcCode,
    ) {
        Assert::stringNotEmpty($this->cardNumber);
        Assert::digits($this->cardNumber);

        if ($this->cvcCode !== null) {
            Assert::stringNotEmpty($this->cvcCode);
            Assert::digits($this->cvcCode);
        }
    }
}
