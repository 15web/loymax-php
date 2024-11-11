<?php

declare(strict_types=1);

namespace Studio15\Loymax\ApiClient\Exception;

use Psr\Http\Message\ResponseInterface;
use Studio15\Loymax\ApiClient\Data\HttpStatusCode;

/**
 * @api
 * Некорректный запрос
 */
final class BadRequest extends ApiClientException
{
    private const TRACE_ID_HEADER = 'X-Loymax-TraceId';

    public string $error;

    public ?string $errorDescription;

    public string $traceId;

    public function __construct(public ResponseInterface $apiResponse)
    {
        /** @var array{error?: non-empty-string, error_description?: non-empty-string|null} $data */
        $data = json_decode(
            json: (string) $apiResponse->getBody(),
            associative: true,
        );

        $this->error = $data['error'] ?? 'Request failed';
        $this->errorDescription = $data['error_description'] ?? null;
        $this->traceId = $this->apiResponse->getHeaderLine(self::TRACE_ID_HEADER);

        parent::__construct(
            $this->errorDescription ?? $this->error,
            HttpStatusCode::HTTP_BAD_REQUEST->value,
        );
    }
}
