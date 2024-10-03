# Loymax PHP SDK

[![Build and check code status](https://github.com/15web/loymax-php/actions/workflows/check.yml/badge.svg)](https://github.com/15web/loymax-php/actions)
[![Psalm coverage](https://shepherd.dev/github/15web/loymax-php/coverage.svg?)](https://shepherd.dev/github/15web/loymax-php)
[![Psalm level](https://shepherd.dev/github/15web/loymax-php/level.svg?)](https://psalm.dev/)


SDK для работы с программой лояльности [Loymax](https://loymax.ru/).

Ускорит внедрение функциональности Loymax в Ваш продукт.

<!-- TOC -->
* [Loymax PHP SDK](#loymax-php-sdk)
  * [Установка](#установка)
  * [Использование](#использование)
    * [Двухфакторная авторизация](#двухфакторная-авторизация)
    * [Публичное API](#публичное-api)
    * [Логирование](#логирование)
    * [Использование своего HTTP-клиента](#использование-своего-http-клиента)
  * [Интеграция с фреймворками](#интеграция-с-фреймворками)
    * [Symfony](#symfony)
    * [Laravel](#laravel)
  * [Дополнительная информация](#дополнительная-информация)
  * [Разработка](#разработка)
  * [Тестирование кода](#тестирование-кода)
  * [Поддержка и обратная связь](#поддержка-и-обратная-связь)
  * [Copyright and license](#copyright-and-license)
<!-- TOC -->

## Установка

```bash
composer require 15web/loymax-sdk
```

**Требования**

Минимальная версия PHP 8.2

SDK использует HTTP-клиент в соответствии с [PSR-18](https://www.php-fig.org/psr/psr-18/) и логгер в соответствии
с [PSR-3](https://www.php-fig.org/psr/psr-3/).

По умолчанию используется [Guzzle](https://github.com/guzzle/guzzle) в качестве HTTP-клиента

Выбор [HTTP-клиента](https://packagist.org/providers/psr/http-client-implementation)
и [логгера](https://packagist.org/providers/psr/log-implementation).

## Использование

```php
use Studio15\Loymax\Loymax;

require __DIR__ . '/vendor/autoload.php';

$loymax = Loymax::create('https://your-project.loymax.tech');

$merchants = $loymax->publicApi()->merchants()->getByIds();
```

### Двухфакторная авторизация

```php
use Studio15\Loymax\Loymax;

require __DIR__ . '/vendor/autoload.php';

$loymax = Loymax::create('https://your-project.loymax.tech');

$twoFactorToken = $loymax->authApi()->issueAccessToken(
    username: '79990001234', // телефон
);

$token = $loymax->authApi()->confirmTwoFactorAuthentication(
    twoFactorAuthToken: $twoFactorToken->twoFactorAuthToken,
    code: '123456', // Код, полученный в SMS
);
```

### Публичное API

```php
use Studio15\Loymax\Loymax;

require __DIR__ . '/vendor/autoload.php';

$loymax = Loymax::create('https://your-project.loymax.tech');

$twoFactorToken = $loymax->authApi()->issueAccessToken(
    username: '79990001234', // телефон
);

$token = $loymax->authApi()->confirmTwoFactorAuthentication(
    twoFactorAuthToken: $twoFactorToken->twoFactorAuthToken,
    code: '123456', // Код, полученный в SMS
);

/**
 * Получение баланса пользователя программы лояльности
 */
$balance = $loymax->publicApi(token: $token->accessToken)->user()->balance();

/** 
 * Получение публичной информации о торговых точках
 */
$merchants = $loymax->publicApi()->merchants()->getByIds();
```

### Логирование

Все запросы и ответы логируются.

В конструктор требуется передать клиент, который реализует `Psr\Log\LoggerInterface`

Пример использования [Monolog](https://github.com/Seldaek/monolog)

```bash
composer require monolog/monolog

```

```php
use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger;
use Studio15\Loymax\Loymax;

require __DIR__ . '/vendor/autoload.php';

$baseUri = 'https://your-project.loymax.tech';

$logger = new Logger('name');
$logger->pushHandler(new StreamHandler('log/loymax-info.log', Level::Info));

$loymax = new Loymax(
    baseUri: $baseUri,
    logger: $logger,
);

$merchants = $loymax->publicApi()->merchants()->getByIds();
```

### Использование своего HTTP-клиента

По умолчанию в SDK используется [Guzzle](https://github.com/guzzle/guzzle) в качестве HTTP-клиента

Пример использования [Symfony HTTP client](https://symfony.com/doc/current/http_client.html)

```bash
composer require symfony/http-client psr/http-client nyholm/psr7
```

```php
use Studio15\Loymax\Loymax;
use Symfony\Component\HttpClient\Psr18Client;

require __DIR__ . '/vendor/autoload.php';

$baseUri = 'https://your-project.loymax.tech';

$httpClient = (new Psr18Client())->withOptions(['base_uri' => $baseUri]);

$loymax = new Loymax(
    httpClient: $httpClient,
);

$merchants = $loymax->publicApi()->merchants()->getByIds();
```

## Интеграция с фреймворками

### Symfony

* https://symfony.com/doc/current/index.html

Для использования класса `Loymax` в качестве сервиса требуется добавить в `config/services.yaml`

```yaml
services: # ...
    Studio15\Loymax\Loymax:
        arguments:
            $httpClient: null
            $baseUri: 'https://your-project.loymax.tech'
```

Применение [Symfony HTTP client](https://symfony.com/doc/current/http_client.html#psr-18-and-psr-17) вместо Guzzle

### Laravel

* https://laravel.com/docs/master

Добавьте в конфигурацию адрес вашего проекта:

* `config/services.php`

```php
<?php

return [
    //
    
    'loymax' => [
        'baseurl' => env('LOYMAX_API_BASEURL', 'https://your-project.loymax.tech'),
    ],
];
```

Для добавления в контейнер зарегистрируйте класс в сервис провайдере:

* `app/Providers/AppServiceProvider.php`

```php
use Studio15\Loymax\Loymax;

public function register(): void
{
    //
    
    $this->app->bind(
        abstract: Loymax::class,
        concrete: static fn (): Loymax => Loymax::create(config('services.loymax.baseurl')),
    );
}
```

Теперь достаточно подключить класс Loymax в любом месте, например в контроллере:

```php
use Studio15\Loymax\Loymax;

class MyController extends Controller
{
    public function merchants(Loymax $loymax)
    {
        $merchants = $loymax->publicApi()->merchants()->getByUids();
    }
}
```

## Дополнительная информация

* [Документация Loymax](https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/)

## Разработка

Loymax SDK — это Open Source продукт под лицензией MIT.

Помощь проекту:

* Создать issue по вашей проблеме
* Отправить pull request

## Тестирование кода

Запуск проверок кода, тестов:

```bash
git clone git@github.com:15web/loymax-sdk.git
cd loymax-sdk
composer update
composer test

```

Проверка покрытия кода тестами:

Установить https://github.com/krakjoe/pcov/blob/develop/INSTALL.md

Запуск:

```bash
composer coverage

```

## Поддержка и обратная связь

Если вы нашли ошибку, пожалуйста, отправьте вопрос напрямую в
Github. [Loymax SDK Issues](https://github.com/15web/loymax-php/issues)

Как всегда, если Вам нужна дополнительная помощь, свяжитесь с нами https://www.15web.ru/contacts

## Copyright and license

Copyright © [Studio 15](http://15web.ru), 2012 - Present.   
Code released under [the MIT license](https://opensource.org/licenses/MIT).
