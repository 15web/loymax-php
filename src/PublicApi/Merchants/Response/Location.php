<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\Merchants\Response;

/**
 * Местоположение торговой точки
 */
final readonly class Location
{
    /**
     * @param positive-int $id Внутренний идентификатор местоположения
     * @param string|null $description Описание
     * @param float $latitude Широта
     * @param float $longitude Долгота
     * @param City $city Город
     * @param string|null $street Улица
     * @param string|null $house Дом
     * @param string|null $building Здание
     * @param string|null $office Офис
     */
    public function __construct(
        public int $id,
        public ?string $description,
        public float $latitude,
        public float $longitude,
        public City $city,
        public ?string $street,
        public ?string $house,
        public ?string $building,
        public ?string $office,
    ) {}
}
