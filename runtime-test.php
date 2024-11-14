<?php

/**
 * Проверка работы SDK в production окружении (без dev зависимостей)
 */

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Studio15\Loymax\Loymax;
use Studio15\Loymax\PublicApi\Cards\MockResponse as CardsMockResponse;

require __DIR__.'/vendor/autoload.php';

function createLoymax(Response $response): Loymax
{
    $client = new Client([
        'handler' => HandlerStack::create(
            new MockHandler([$response]),
        ),
    ]);

    return new Loymax(
        httpClient: $client,
    );
}

/**
 * Public API
 *
 * Cards
 */
\createLoymax(CardsMockResponse\EmitVirtualResponse::getResponse())->publicApi()->cards()->emitVirtual();
\createLoymax(CardsMockResponse\GetCardsResponse::getResponse())->publicApi()->cards()->getCards();
\createLoymax(CardsMockResponse\GetEmitVirtualResponse::getResponse())->publicApi()->cards()->getEmitVirtual();
\createLoymax(CardsMockResponse\QrCodeResponse::getResponse())->publicApi()->cards()->qrCode(cardId: 1);
\createLoymax(CardsMockResponse\SetCardResponse::getResponse())->publicApi()->cards()->setCard(cardNumber: '1001100110011001', cvcCode: '123');

/**
 * Coupons
 */

/**
 * History
 */

/**
 * Merchants
 */

/**
 * Notification
 */

/**
 * Offer
 */

/**
 * Password
 */

/**
 * Pushes
 */

/**
 * Registration
 */

/**
 * User
 */

/**
 * History
 */

/**
 * Modules
 *
 * CommunicationService
 */


echo 'Done';
