<?php

declare(strict_types=1);

namespace Studio15\Loymax\Test\PublicApi\User\SendAnswers;

use InvalidArgumentException;
use Iterator;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Studio15\Loymax\PublicApi\User\Request\Answer;

/**
 * @internal
 */
#[TestDox('Ответ на вопрос анкеты')]
final class AnswerTest extends TestCase
{
    /**
     * @param non-negative-int $questionId Внутренний идентификатор вопроса
     * @param non-negative-int $questionGroupId Внутренний идентификатор группы вопросов, к которой относится вопрос
     * @param int|string|null $value Значение фиксированного ответа
     * @param list<non-empty-string|non-negative-int> $fixedAnswerIds Внутренние идентификаторы фиксированных ответов
     * @param string|null $tag Тег для группировки ответов на составные вопросы
     */
    #[TestDox('Невалидный вопрос')]
    #[DataProvider('invalidAnswerProvider')]
    public function testInvalidAnswer(
        int $questionId,
        int $questionGroupId,
        null|int|string $value = null,
        array $fixedAnswerIds = [],
        ?string $tag = null,
    ): void {
        $this->expectException(InvalidArgumentException::class);

        new Answer(
            questionId: $questionId,
            questionGroupId: $questionGroupId,
            value: $value,
            fixedAnswerIds: $fixedAnswerIds,
            tag: $tag,
        );
    }

    public static function invalidAnswerProvider(): Iterator
    {
        yield 'отрицательный questionId' => [-1, 1];

        yield 'отрицательный questionGroupId' => [1, -1];

        yield 'пустая строка в fixedAnswerIds' => [1, 1, null, ['']];

        yield 'отрицательное число в fixedAnswerIds' => [1, 1, null, [-1]];

        yield 'пустая строка в tag' => [1, 1, null, [], ''];
    }
}
