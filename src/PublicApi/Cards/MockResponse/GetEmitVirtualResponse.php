<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\Cards\MockResponse;

use GuzzleHttp\Psr7\Response;

final class GetEmitVirtualResponse
{
    public static function getResponse(): Response
    {
        return new Response(
            body: <<<'JSON'
                {
                  "data":  {
                    "currentCountOfVirtualCards": 1,
                    "isVirtualCardEmissionAllowed": false
                  },
                  "result": {
                    "state": "Success",
                    "httpCode": 200,
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
