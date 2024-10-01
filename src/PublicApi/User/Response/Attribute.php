<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\User\Response;

use DateTimeImmutable;
use Symfony\Component\Serializer\Attribute\SerializedName;

/**
 * Аттрибут клиента
 */
final class Attribute
{
    /**
     * @param AttributeType $type Внутренний тип атрибута Лоймакс
     * @param string|null $stringValue Значение аттрибута в случае если тип - строка
     * @param DateTimeImmutable|null $dateValue Значение аттрибута в случае если тип - дата
     * @param list<non-empty-string>|null $answers Значение атрибута в случае если тип - список ответов
     */
    public function __construct(
        #[SerializedName('$type')]
        public AttributeType $type,
        public ?string $stringValue = null,
        public ?DateTimeImmutable $dateValue = null,
        public ?array $answers = null,
    ) {}
}
