<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\Notification\Response;

use Symfony\Component\Serializer\Attribute\SerializedName;

/**
 * @api
 * Оповещение
 */
final readonly class Notification
{
    /**
     * @param positive-int $id Внутренний идентификатор оповещения
     * @param non-empty-string $title Заголовок оповещения
     * @param non-empty-string $body Содержимое оповещения
     * @param non-empty-string $summary Краткое содержание оповещения
     * @param non-empty-string $creationDate Дата и время отправки оповещения
     * @param bool $isRead Прочитано ли оповещение
     */
    public function __construct(
        public int $id,
        public string $title,
        public string $body,
        public string $summary,
        public string $creationDate,
        #[SerializedName('isReaded')]
        public bool $isRead,
    ) {}
}
