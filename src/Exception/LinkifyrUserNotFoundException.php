<?php

declare(strict_types=1);

namespace LinkifyrApi\Exception;

use LinkifyrApi\Exception\LinkifyrException;

class LinkifyrUserNotFoundException extends LinkifyrException
{
    public function __construct(
        string $message = 'User not found',
        int $code = 404,
        ?\Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
