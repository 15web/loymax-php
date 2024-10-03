<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\User\Request;

use Webmozart\Assert\Assert;

/**
 * @api
 * Ответ на вопрос анкеты
 */
final readonly class Answer
{
    /**
     * @param non-negative-int $questionId Внутренний идентификатор вопроса
     * @param non-negative-int $questionGroupId Внутренний идентификатор группы вопросов, к которой относится вопрос
     * @param int|string|null $value Значение фиксированного ответа
     * @param list<non-empty-string|non-negative-int> $fixedAnswerIds Внутренние идентификаторы фиксированных ответов
     * @param string|null $tag Тег для группировки ответов на составные вопросы
     */
    public function __construct(
        public int $questionId,
        public int $questionGroupId,
        public null|int|string $value = null,
        public array $fixedAnswerIds = [],
        public ?string $tag = null,
    ) {
        Assert::natural($questionId);
        Assert::natural($questionGroupId);

        foreach ($fixedAnswerIds as $fixedAnswerId) {
            if (\is_string($fixedAnswerId)) {
                Assert::stringNotEmpty($fixedAnswerId);
            }

            if (\is_int($fixedAnswerId)) {
                Assert::natural($fixedAnswerId);
            }
        }

        Assert::nullOrStringNotEmpty($tag);
    }
}
