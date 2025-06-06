<?php

declare(strict_types=1);

namespace LinkifyrApi\Exception;

class LinkifyrException extends \Exception
{
    public function __construct(
        string $message = 'An error occurred in the Linkifyr API',
        int $code = 0,
        ?\Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
