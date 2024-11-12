<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\Files;

use Studio15\Loymax\ApiClient\ApiClient;
use Studio15\Loymax\ApiClient\CreateRequest;
use Studio15\Loymax\ApiClient\CreateSerializer;
use Studio15\Loymax\ApiClient\Data\Method;
use Studio15\Loymax\ApiClient\Exception\ApiClientException;
use Studio15\Loymax\PublicApi\Files\Response\File;
use Symfony\Component\Uid\Uuid;

/**
 * Возвращает информацию о параметрах файла по его внешнему идентификатору
 *
 * @see https://docs.loymax.net/xwiki/bin/view/Main/Integration/Ways_to_use_API/API_methods/Methods_of_public_api/Files/#H41243E43743244043044943043544243843D44443E44043C43044643844E43E43F43044043043C43544244043044544443043943B43043F43EA043543343E43243D43544843D43543C443A043843443543D44243844443843A43044243E440443
 */
final readonly class GetFileByGuid
{
    public function __construct(
        private ApiClient $apiClient,
    ) {}

    /**
     * @param Uuid $guid Внешний идентификатор файла
     *
     * @throws ApiClientException
     */
    public function __invoke(Uuid $guid): File
    {
        $apiRequest = (new CreateRequest())(
            method: Method::GET,
            uri: "/publicapi/v1.2/Files/Guid/{$guid->toString()}",
        );

        $apiResponse = $this->apiClient->sendRequest($apiRequest);

        /** @var File $file */
        $file = (new CreateSerializer())()->denormalize(
            data: $apiResponse->data ?? [],
            type: File::class,
        );

        return $file;
    }
}
