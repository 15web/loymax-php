<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\Cards\Response;

use DateTimeImmutable;

/**
 * @api
 * Карта
 */
final readonly class Card
{
    /**
     * @param positive-int $id Внутренний идентификатор карты
     * @param non-empty-string $qrContent QR-код
     * @param CardState $state Статус карты
     * @param non-empty-string $number Номер карты
     * @param non-empty-string $barCode Штрих-код карты
     * @param bool $block Статус блокировки карты (заблокирована/не заблокирована)
     * @param DateTimeImmutable|null $expiryDate Дата истечения срока действия карты (null — без ограничения времени действия)
     * @param CardCategory $cardCategory Описание категории карты
     * @param Balance $accumulated Информация о полученных за время участия в ПЛ бонусов (требуется в случае, если Партнер не использует функциональность мультивалютных счетов)
     * @param Balance $paid Информация о потраченных за время участия в ПЛ бонусов (требуется в случае, если Партнер не использует функциональность мультивалютных счетов)
     * @param list<Balance> $accumulatedInfo Информация о полученных за время участия в ПЛ бонусов (требуется в случае, если Партнер использует функциональность мультивалютных счетов)
     * @param list<Balance> $paidInfo Информация о потраченных за время участия в ПЛ бонусов (требуется в случае, если Партнер использует функциональность мультивалютных счетов)
     * @param CardActionAccessInfo $cardActionAccessInfo Доступность действий с картой
     * @param CardOwnerInfo $cardOwnerInfo Информация о владельце карты
     */
    public function __construct(
        public int $id,
        public string $qrContent,
        public CardState $state,
        public string $number,
        public string $barCode,
        public bool $block,
        public ?DateTimeImmutable $expiryDate,
        public CardCategory $cardCategory,
        public Balance $accumulated,
        public Balance $paid,
        public array $accumulatedInfo,
        public array $paidInfo,
        public CardActionAccessInfo $cardActionAccessInfo,
        public CardOwnerInfo $cardOwnerInfo,
    ) {}
}
