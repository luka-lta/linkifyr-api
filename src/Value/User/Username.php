<?php

declare(strict_types=1);

namespace LinkifyrApi\Value\User;

use InvalidArgumentException;
use LinkifyrApi\Exception\LinkifyrValidationException;

final class Username
{
    private function __construct(private readonly string $value)
    {
        $trimmed = trim($value);
        if (strlen($trimmed) < 3) {
            throw new LinkifyrValidationException("Username must be at least 3 characters");
        }
        if (strlen($trimmed) > 50) {
            throw new LinkifyrValidationException("Username must not exceed 50 characters");
        }
        if (!preg_match('/^[a-zA-Z0-9_]+$/', $trimmed)) {
            throw new LinkifyrValidationException("Username can only contain letters, numbers, and underscores");
        }
    }

    public static function from(string $value): self
    {
        return new self($value);
    }

    public function value(): string
    {
        return $this->value;
    }

    public function equals(Username $other): bool
    {
        return $this->value === $other->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
