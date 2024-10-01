<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\Merchants\Response;

/**
 * График работы
 */
final readonly class ScheduleModel
{
    /**
     * @param list<Schedule>|null $mon Понедельник
     * @param list<Schedule>|null $tue Вторник
     * @param list<Schedule>|null $wed Среда
     * @param list<Schedule>|null $thu Четверг
     * @param list<Schedule>|null $fri Пятница
     * @param list<Schedule>|null $sat Суббота
     * @param list<Schedule>|null $sun Воскресенье
     */
    public function __construct(
        public ?array $mon,
        public ?array $tue,
        public ?array $wed,
        public ?array $thu,
        public ?array $fri,
        public ?array $sat,
        public ?array $sun,
    ) {}
}
