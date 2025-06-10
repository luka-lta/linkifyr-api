<?php

declare(strict_types=1);

namespace LinkifyrApi\Value\User;

use LinkifyrApi\Exception\LinkifyrValidationException;
use Ramsey\Uuid\Uuid;

class UserId
{
    public function __construct(
        private readonly string $value
    ) {
    }

    public static function from(string $value): self
    {
        if (!Uuid::isValid($value)) {
            throw new LinkifyrValidationException('Invalid UUID format');
        }

        return new self($value);
    }

    public static function generate(): self
    {
        return new self(Uuid::uuid1()->toString());
    }

    public function value(): string
    {
        return $this->value;
    }

    public function equals(UserId $other): bool
    {
        return $this->value === $other->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
