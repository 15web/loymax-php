<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi;

use Studio15\Loymax\ApiClient\ApiClient;
use Studio15\Loymax\ApiClient\Exception\ApiClientException;
use Studio15\Loymax\PublicApi\Files\GetFileByGuid;
use Studio15\Loymax\PublicApi\Files\GetFileById;
use Studio15\Loymax\PublicApi\Files\Response\File;
use Symfony\Component\Uid\Uuid;

/**
 * File. Методы для работы с файлами
 *
 * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/Files/
 */
final readonly class Files
{
    public function __construct(
        private ApiClient $apiClient,
    ) {}

    /**
     * Возвращает информацию о параметрах файла по его внутреннему идентификатору
     *
     * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/Files/#H41243E43743244043044943043544243843D44443E44043C43044643844E43E43F43044043043C43544244043044544443043943B43043F43EA043543343E43243D44344244043543D43D43543C44343843443543D44243844443843A43044243E440443
     *
     * @param positive-int $id Внутренний идентификатор файла
     *
     * @throws ApiClientException
     */
    public function getFileById(int $id): File
    {
        $getFileById = new GetFileById(
            apiClient: $this->apiClient,
        );

        return ($getFileById)($id);
    }

    /**
     * Возвращает информацию о параметрах файла по его внешнему идентификатору
     *
     * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/Files/#H41243E43743244043044943043544243843D44443E44043C43044643844E43E43F43044043043C43544244043044544443043943B43043F43EA043543343E43243D43544843D43543C443A043843443543D44243844443843A43044243E440443
     *
     * @param Uuid $guid Внешний идентификатор файла
     *
     * @throws ApiClientException
     */
    public function getFileByGuid(Uuid $guid): File
    {
        $getByIds = new GetFileByGuid(
            apiClient: $this->apiClient,
        );

        return ($getByIds)($guid);
    }
}
