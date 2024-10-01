<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi;

use Studio15\Loymax\ApiClient\ApiClient;
use Studio15\Loymax\PublicApi\Data\Pagination;
use Studio15\Loymax\PublicApi\Exception\DenormalizeResponseError;
use Studio15\Loymax\PublicApi\Merchants\GetByIds;
use Studio15\Loymax\PublicApi\Merchants\GetByUids;
use Studio15\Loymax\PublicApi\Merchants\Request\GetByIdsRequest;
use Studio15\Loymax\PublicApi\Merchants\Request\GetByUidsRequest;
use Studio15\Loymax\PublicApi\Merchants\Response\Merchant;

/**
 * Merchants. Методы для работы с торговыми точками
 *
 * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/Merchants/
 *
 * @internal
 */
final readonly class Merchants
{
    public function __construct(
        private ApiClient $apiClient,
    ) {}

    /**
     * Возвращает информацию о торговых точках (фильтр по внешним идентификаторам торговых точек)
     *
     * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/Merchants/#H41243E43743244043044943043544243843D44443E44043C43044643844E43E44243E44043343E43244B44544243E44743A4304452844443843B44C44244043F43E43243D43544843D43843C43843443543D44243844443843A43044243E44043043C44243E44043343E43244B44544243E44743543A29
     *
     * @param list<non-empty-string> $merchantsUids Фильтр по внешним идентификаторам торговых точек
     * @param non-negative-int $from Порядковый номер начального элемента выборки
     * @param positive-int $count Количество возвращаемых элементов выборки
     *
     * @return list<Merchant>
     *
     * @throws DenormalizeResponseError
     */
    public function getByUids(array $merchantsUids = [], int $from = 0, int $count = 10): array
    {
        $request = new GetByUidsRequest(
            merchantsUids: $merchantsUids,
        );

        $pagination = new Pagination(
            from: $from,
            count: $count,
        );

        $getByUids = new GetByUids(
            apiClient: $this->apiClient,
        );

        return ($getByUids)(
            request: $request,
            pagination: $pagination,
        );
    }

    /**
     * Возвращает информацию о торговых точках (фильтр по внутренним идентификаторам торговых точек)
     *
     * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/Merchants/#H41243E43743244043044943043544243843D44443E44043C43044643844E43E44243E44043343E43244B44544243E44743A4304452844443843B44C44244043F43E43243D44344244043543D43D43843C43843443543D44243844443843A43044243E44043043C44243E44043343E43244B44544243E44743543A29
     *
     * @param list<positive-int> $merchantsIds Фильтр по внутренним идентификаторам торговых точек
     * @param non-negative-int $from Порядковый номер начального элемента выборки
     * @param positive-int $count Количество возвращаемых элементов выборки
     *
     * @return list<Merchant>
     *
     * @throws DenormalizeResponseError
     */
    public function getByIds(array $merchantsIds = [], int $from = 0, int $count = 10): array
    {
        $request = new GetByIdsRequest(
            merchantsIds: $merchantsIds,
        );

        $pagination = new Pagination(
            from: $from,
            count: $count,
        );

        $getByIds = new GetByIds(
            apiClient: $this->apiClient,
        );

        return ($getByIds)(
            request: $request,
            pagination: $pagination,
        );
    }
}
