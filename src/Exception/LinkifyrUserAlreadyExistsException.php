<?php

declare(strict_types=1);

namespace LinkifyrApi\Exception;

use Fig\Http\Message\StatusCodeInterface;

class LinkifyrUserAlreadyExistsException extends LinkifyrException
{
    public function __construct(
        string $message = 'User already exists',
        int $code = StatusCodeInterface::STATUS_CONFLICT,
        ?\Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
