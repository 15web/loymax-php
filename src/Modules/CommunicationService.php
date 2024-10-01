<?php

declare(strict_types=1);

namespace Studio15\Loymax\Modules;

use Studio15\Loymax\ApiClient\ApiClient;
use Studio15\Loymax\Modules\CommunicationService\GetCommunications;
use Studio15\Loymax\Modules\CommunicationService\Response\CommunicationList;
use Studio15\Loymax\PublicApi\Exception\DenormalizeResponseError;

/**
 * CommunicationService. Персональные предложения с использованием механик Machine Learning
 *
 * @see https://docs.loymax.net/xwiki/bin/view/Main/Installation_and_configuration/Extra_modules/CommunicationService_ML/
 *
 * @internal
 */
final readonly class CommunicationService
{
    public function __construct(
        private ApiClient $apiClient,
    ) {}

    /**
     * Получение информации о персональном предложении
     *
     * @see https://docs.loymax.net/xwiki/bin/view/Main/Installation_and_configuration/Extra_modules/CommunicationService_ML/#H41F43E43B44344743543D43843543843D44443E44043C43044643843843E43F43544044143E43D43043B44C43D43E43C43F44043543443B43E43643543D438438
     *
     * @throws DenormalizeResponseError
     */
    public function getCommunications(): CommunicationList
    {
        $getCommunications = new GetCommunications(
            apiClient: $this->apiClient,
        );

        return ($getCommunications)();
    }
}
