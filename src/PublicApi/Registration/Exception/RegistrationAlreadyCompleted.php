<?php

declare(strict_types=1);

namespace Studio15\Loymax\PublicApi\Registration\Exception;

use Exception;

/**
 * Регистрация уже была завершена
 */
final class RegistrationAlreadyCompleted extends Exception {}
