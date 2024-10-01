<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\Merchants\Response;

/**
 * Торговая точка
 */
final readonly class Merchant
{
    /**
     * @param int $id Внутренний идентификатор торговой точки
     * @param non-empty-string $uid Внешний идентификатор торговой точки
     * @param string $title Название торговой точки
     * @param non-empty-string $brandId Id бренда
     * @param string|null $description Описание торговой точки
     * @param Location $location Местоположение торговой точки
     * @param ScheduleModel|null $scheduleModel График работы
     * @param bool $isArchived Признак состояния торговой точки (true — архивная, false — неархивная)
     * @param list<AdditionalInfo>|null $additionalInfo Дополнительная информация о торговой точке
     */
    public function __construct(
        public int $id,
        public string $uid,
        public string $title,
        public string $brandId,
        public ?string $description,
        public Location $location,
        public ?ScheduleModel $scheduleModel,
        public bool $isArchived,
        public ?array $additionalInfo,
    ) {}
}
