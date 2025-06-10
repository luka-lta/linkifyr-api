<?php

declare(strict_types=1);

namespace LinkifyrApi\Exception;

use Fig\Http\Message\StatusCodeInterface;

class LinkifyrDatabaseException extends LinkifyrException
{
    public function __construct(
        string $message = 'A database error occurred in the Linkifyr API',
        int $code = StatusCodeInterface::STATUS_INTERNAL_SERVER_ERROR,
        ?\Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
