<?php

declare(strict_types=1);

namespace LinkifyrApi\Value\User;

use LinkifyrApi\Exception\LinkifyrValidationException;

final class Email
{
    private function __construct(private readonly string $value)
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new LinkifyrValidationException("Invalid email address: $value");
        }
        if (strlen($value) > 255) {
            throw new LinkifyrValidationException("Email address is too long: $value");
        }
        if (strlen($value) < 3) {
            throw new LinkifyrValidationException("Email address is too short: $value");
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

    public function equals(Email $other): bool
    {
        return $this->value === $other->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
