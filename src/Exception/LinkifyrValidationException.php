<?php

declare(strict_types=1);

namespace LinkifyrApi\Exception;

use Fig\Http\Message\StatusCodeInterface;

class LinkifyrValidationException extends LinkifyrException
{
    public function __construct(
        string $message = 'Validation error in Linkifyr API',
        int $code = StatusCodeInterface::STATUS_UNPROCESSABLE_ENTITY,
        ?\Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
