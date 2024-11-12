<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\Files\Response;

use DateTimeImmutable;
use Symfony\Component\Uid\Uuid;

/**
 * @api
 * Файл
 */
final readonly class File
{
    /**
     * @param positive-int $id Внутренний идентификатор файла
     * @param Uuid $guid Внешний идентификатор файла
     * @param non-empty-string $name Название файла
     * @param DateTimeImmutable|null $modified Дата последнего изменения в файле
     */
    public function __construct(
        public int $id,
        public Uuid $guid,
        public string $name,
        public ?DateTimeImmutable $modified,
    ) {}
}
