<?php

declare(strict_types=1);

namespace Studio15\Loymax\Test\PublicApi\User\Response;

use Iterator;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestDox;
use Studio15\Loymax\PublicApi\User\Response\User;
use Studio15\Loymax\PublicApi\User\Response\UserState;
use Studio15\Loymax\Test\TestCase;

/**
 * @internal
 */
#[TestDox('Информация о текущем авторизованном клиенте')]
final class UserTest extends TestCase
{
    /**
     * @param non-empty-list<non-empty-string|null> $data
     */
    #[TestDox('Получение полного имени')]
    #[DataProvider('fullnameDataProvider')]
    public function testFullname(array $data): void
    {
        $user = new User(
            id: 1,
            personUid: 'uuid',
            lastName: $data[0],
            firstName: $data[1],
            patronymicName: $data[2],
            birthDay: null,
            state: UserState::Normal,
        );

        self::assertSame($user->fullName(), $data[3]);
    }

    public static function fullnameDataProvider(): Iterator
    {
        yield 'Полностью' => [['Иванов', 'Иван', 'Иванович', 'Иванов Иван Иванович']];

        yield 'Без отчества' => [['Иванов', 'Иван', null, 'Иванов Иван']];

        yield 'Без фамилии' => [[null, 'Иван', 'Иванович', 'Иван Иванович']];

        yield 'Без имени' => [['Иванов', null, 'Иванович', 'Иванов Иванович']];

        yield 'Нет данных' => [[null, null, null, null]];
    }
}
