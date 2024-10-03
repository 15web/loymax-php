<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\History\Response;

use Symfony\Component\Uid\Uuid;

/**
 * @api
 * Операция
 */
final readonly class Operation
{
    /**
     * @param Uuid $id ID операции
     * @param non-empty-string $dateTime Дата операции
     * @param OperationType $type Тип операции
     * @param non-empty-string $description Описание торговой точки
     * @param non-empty-string|null $identity Идентификатор клиента
     * @param Location|null $location Место события
     * @param Brand|null $brand Информация о бренде
     */
    public function __construct(
        public Uuid $id,
        public string $dateTime,
        public OperationType $type,
        public string $description,
        public OperationData $data,
        public ?string $identity,
        public ?Location $location = null,
        public ?Brand $brand = null,
    ) {}
}
