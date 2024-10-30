<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi;

use Studio15\Loymax\ApiClient\ApiClient;
use Studio15\Loymax\ApiClient\Exception\ApiClientException;
use Studio15\Loymax\PublicApi\Cards\GetCards;
use Studio15\Loymax\PublicApi\Cards\GetQrCode;
use Studio15\Loymax\PublicApi\Cards\Request\GetQrCodeRequest;
use Studio15\Loymax\PublicApi\Cards\Response\Card;
use Studio15\Loymax\PublicApi\Cards\Response\QrCode;

/**
 * Cards. Методы для работы с картами
 *
 * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/Cards/
 */
final readonly class Cards
{
    public function __construct(
        private ApiClient $apiClient,
    ) {}

    /**
     * Возвращает список карт текущего клиента и все операции по ним
     *
     * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/Cards/#H41243E43743244043044943043544244143F43844143E43A43A43044044244243543A44344943543343E43A43B43843543D44243043843244143543E43F43544043044643843843F43E43D43843C
     *
     * @return list<Card>
     *
     * @throws ApiClientException
     */
    public function getCards(): array
    {
        $getCards = new GetCards(
            apiClient: $this->apiClient,
        );

        return ($getCards)();
    }

    /**
     * Генерирует QR-код для карты по ее внутреннему идентификатору
     *
     * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/Cards/#H41343543D435440438440443435442A0QR-43A43E434A043443B44F43A43044044244B43F43E43543543243D44344244043543D43D43543C44343843443543D44243844443843A43044243E440443
     *
     * @param positive-int $cardId
     *
     * @throws ApiClientException
     */
    public function qrCode(int $cardId): QrCode
    {
        $request = new GetQrCodeRequest(
            cardId: $cardId,
        );

        $qrCode = new GetQrCode(
            apiClient: $this->apiClient,
        );

        return ($qrCode)($request);
    }
}
