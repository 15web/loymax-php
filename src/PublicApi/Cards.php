<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi;

use Studio15\Loymax\ApiClient\ApiClient;
use Studio15\Loymax\ApiClient\Exception\ApiClientException;
use Studio15\Loymax\PublicApi\Cards\EmitVirtual;
use Studio15\Loymax\PublicApi\Cards\GetCards;
use Studio15\Loymax\PublicApi\Cards\GetEmitVirtual;
use Studio15\Loymax\PublicApi\Cards\GetQrCode;
use Studio15\Loymax\PublicApi\Cards\Request\SetCardRequest;
use Studio15\Loymax\PublicApi\Cards\Response\Card;
use Studio15\Loymax\PublicApi\Cards\Response\EmittedCard;
use Studio15\Loymax\PublicApi\Cards\Response\GetEmitVirtualResponse;
use Studio15\Loymax\PublicApi\Cards\Response\QrCode;
use Studio15\Loymax\PublicApi\Cards\SetCard;

/**
 * Cards. Методы для работы с картами
 *
 * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/Cards/
 *
 * Конфигурирование процесса привязки физической и виртуальной карты
 * @see https://docs.loymax.net/xwiki/bin/view/Main/Installation_and_configuration/System_configuration/Internal_settings/Card_issue_configuring/
 *
 * Конфигурирование выдачи виртуальной карты при регистрации
 * @see https://docs.loymax.net/xwiki/bin/view/Main/Installation_and_configuration/System_configuration/Internal_settings/#EmitCards
 */
final readonly class Cards
{
    public function __construct(
        private ApiClient $apiClient,
    ) {}

    /**
     * Возвращает информацию о возможности выпуска виртуальной карты
     *
     * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/Cards/#H41243E43743244043044943043544243843D44443E44043C43044643844E43E43243E43743C43E43643D43E44144243843244B43F44344143A43043243844044244343043B44C43D43E43943A43044044244B
     *
     * @throws ApiClientException
     */
    public function getEmitVirtual(): GetEmitVirtualResponse
    {
        $getEmitVirtual = new GetEmitVirtual(
            apiClient: $this->apiClient,
        );

        return ($getEmitVirtual)();
    }

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
     * Прикрепляет карту
     *
     * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/Cards/#H41F44043843A44043543F43B44F43544243A430440442443
     *
     * @param non-empty-string $cardNumber Номер карты
     * @param non-empty-string|null $cvcCode CVC-код
     *
     * @throws ApiClientException
     */
    public function setCard(string $cardNumber, ?string $cvcCode = null): EmittedCard
    {
        $requestBody = new SetCardRequest(
            cardNumber: $cardNumber,
            cvcCode: $cvcCode,
        );

        $setCard = new SetCard(
            apiClient: $this->apiClient,
        );

        return ($setCard)($requestBody);
    }

    /**
     * Выпускает виртуальную карту
     *
     * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/Cards/#H41244B43F44344143A43043544243243844044244343043B44C43D44344EA043A430440442443
     *
     * @throws ApiClientException
     */
    public function emitVirtual(): EmittedCard
    {
        $emitVirtual = new EmitVirtual(
            apiClient: $this->apiClient,
        );

        return ($emitVirtual)();
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
        $qrCode = new GetQrCode(
            apiClient: $this->apiClient,
        );

        return ($qrCode)($cardId);
    }
}
