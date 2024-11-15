<?php

declare(strict_types=1);

namespace Studio15\Loymax\ApiClient\Exception;

use Psr\Http\Message\ResponseInterface;
use Studio15\Loymax\ApiClient\Data\HttpStatusCode;
use Studio15\Loymax\ApiClient\Response\Response;

/**
 * @api
 * Ответ содержит ошибки
 */
final class InvalidResponse extends ApiClientException
{
    private const TRACE_ID_HEADER = 'X-Loymax-TraceId';
    private const DEFAULT_MESSAGE = 'Loymax HTTP API Error';

    public ?string $messageCode;

    public mixed $data;

    public string $traceId;

    public function __construct(ResponseInterface $apiResponse, Response $deserializedResponse)
    {
        $message = $deserializedResponse->result?->message;
        if ($message === null) {
            $message = self::DEFAULT_MESSAGE;
        }

        $this->message = $message;
        $this->messageCode = $deserializedResponse->result?->messageCode;
        $this->data = $deserializedResponse->data;

        $this->traceId = $apiResponse->getHeaderLine(self::TRACE_ID_HEADER);

        parent::__construct(
            message: $message,
            code: HttpStatusCode::BAD_REQUEST->value,
        );
    }
}
