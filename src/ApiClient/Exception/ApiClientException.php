<?php

declare(strict_types=1);

namespace Studio15\Loymax\ApiClient\Exception;

use RuntimeException;

/**
 * Исключение, выбрасываемое клиентом API
 */
abstract class ApiClientException extends RuntimeException {}
