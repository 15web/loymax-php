<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi;

use DateTimeImmutable;
use Studio15\Loymax\ApiClient\ApiClient;
use Studio15\Loymax\ApiClient\Exception\ApiClientException;
use Studio15\Loymax\PublicApi\Data\Pagination;
use Studio15\Loymax\PublicApi\History\GetAggregateWithdrawRewardPurchase;
use Studio15\Loymax\PublicApi\History\GetHistory;
use Studio15\Loymax\PublicApi\History\Request\GetAggregateWithdrawRewardPurchaseRequest;
use Studio15\Loymax\PublicApi\History\Request\GetHistoryRequest;
use Studio15\Loymax\PublicApi\History\Request\HistoryItemType;
use Studio15\Loymax\PublicApi\History\Response\AggregatedOperations;
use Studio15\Loymax\PublicApi\History\Response\OperationHistory;

/**
 * History. Методы для работы с историческими данными
 *
 * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/History/
 */
final readonly class History
{
    public function __construct(
        private ApiClient $apiClient,
    ) {}

    /**
     * Возвращает историю операций клиента
     *
     * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/History/#H41243E43743244043044943043544243844144243E44043844E43E43F43544043044643843943A43B43843543D442430
     *
     * @param DateTimeImmutable|null $fromDate Начальная дата периода выборки
     * @param DateTimeImmutable|null $toDate Конечная дата периода выборки
     * @param HistoryItemType|null $historyItemType Тип события в истории
     * @param non-negative-int $from Порядковый номер начального элемента выборки
     * @param positive-int $count Количество возвращаемых элементов выборки
     *
     * @throws ApiClientException
     */
    public function getHistory(
        ?DateTimeImmutable $fromDate = null,
        ?DateTimeImmutable $toDate = null,
        ?HistoryItemType $historyItemType = null,
        int $from = 0,
        int $count = 10,
    ): OperationHistory {
        $request = new GetHistoryRequest(
            fromDate: $fromDate,
            toDate: $toDate,
            historyItemType: $historyItemType,
        );

        $pagination = new Pagination(
            from: $from,
            count: $count,
        );

        $getHistory = new GetHistory(
            apiClient: $this->apiClient,
        );

        return ($getHistory)(
            request: $request,
            pagination: $pagination,
        );
    }

    /**
     * Возвращает сумму покупок, сумму начисленных и списанных бонусов в рамках покупок
     *
     * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/History/#H41243E43743244043044943043544244144343C43C44343F43E43A44343F43E43A2C44144343C43C44343D43044743844143B43543D43D44B44543844143F43844143043D43D44B44543143E43D44344143E43243244043043C43A43044543F43E43A44343F43E43A
     *
     * @param DateTimeImmutable|null $fromDate Начальная дата периода выборки
     * @param DateTimeImmutable|null $toDate Конечная дата периода выборки
     * @param HistoryItemType|null $historyItemType Тип события в истории
     *
     * @throws ApiClientException
     */
    public function getAggregateWithdrawRewardPurchase(
        ?DateTimeImmutable $fromDate = null,
        ?DateTimeImmutable $toDate = null,
        ?HistoryItemType $historyItemType = null,
    ): AggregatedOperations {
        $request = new GetAggregateWithdrawRewardPurchaseRequest(
            fromDate: $fromDate,
            toDate: $toDate,
            historyItemType: $historyItemType,
        );

        $getHistory = new GetAggregateWithdrawRewardPurchase(
            apiClient: $this->apiClient,
        );

        return ($getHistory)(
            request: $request,
        );
    }
}
