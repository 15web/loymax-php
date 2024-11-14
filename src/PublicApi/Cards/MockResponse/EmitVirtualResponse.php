<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\Cards\MockResponse;

use GuzzleHttp\Psr7\Response;

final class EmitVirtualResponse
{
    public static function getResponse(): Response
    {
        return new Response(
            status: 201,
            body: <<<'JSON'
                {
                  "data": {
                    "id": 456,
                    "state": "Activated",
                    "number": "1011101100220011",
                    "barCode": "1011101100220011",
                    "block": false,
                    "expiryDate": "2024-03-25T12:18:27Z",
                    "cardCategory": {
                      "$type": "Loymax.Common.Contract.Model.Cards.CardCategoryInfo, Loymax.Common.Contract",
                      "description": null,
                      "cardCount": 0,
                      "id": 1,
                      "title": "Виртуальная карта",
                      "logicalName": "VirtualCard",
                      "images": []
                    }
                  },
                  "result": {
                    "state": "Success",
                    "message": null,
                    "messageCode": null,
                    "exception": null,
                    "validationErrors": null
                  }
                }
                JSON
        );
    }
}
