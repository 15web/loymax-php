<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\Cards\MockResponse;

use GuzzleHttp\Psr7\Response;

final class QrCodeResponse
{
    public static function getResponse(): Response
    {
        return new Response(
            body: <<<'JSON'
                {
                  "data":  {
                    "codeGeneratedDate": "2024-10-29T09:26:48Z",
                    "code": "1001877399942540QR2058410873",
                    "lifeTime": 86400
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
