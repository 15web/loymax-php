<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\Cards\Response;

/**
 * Статус карты
 */
enum CardState: string
{
    /**
     * Выпуск
     */
    case Emitted = 'Emitted';

    /**
     * Упакована
     */
    case Packed = 'Packed';

    /**
     * Активирована
     */
    case Activated = 'Activated';

    /**
     * Заменена
     */
    case Replaced = 'Replaced';

    /**
     * Создается
     */
    case Creating = 'Creating';

    /**
     * Создана
     */
    case Created = 'Created';

    /**
     * Готова к выпуску
     */
    case Prepared = 'Prepared';

    /**
     * Выпущена
     */
    case Issued = 'Issued';

    /**
     * Просрочена
     */
    case Expired = 'Expired';
}
