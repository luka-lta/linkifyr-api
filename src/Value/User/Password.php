<?php

declare(strict_types=1);

namespace LinkifyrApi\Value\User;

use InvalidArgumentException;
use LinkifyrApi\Exception\LinkifyrValidationException;

final class Password
{
    private function __construct(
        private readonly string $password,
    ) {
    }

    public static function fromPlain(string $plainPassword): self
    {
        if (strlen($plainPassword) < 8) {
            throw new LinkifyrValidationException('Password must be at least 8 characters long');
        }

        if (strlen($plainPassword) > 64) {
            throw new LinkifyrValidationException('Password must be less than 64 characters long');
        }

        if (!preg_match('/[A-Z]/', $plainPassword)) {
            throw new LinkifyrValidationException('Password must contain at least one uppercase letter');
        }

        if (!preg_match('/[a-z]/', $plainPassword)) {
            throw new LinkifyrValidationException('Password must contain at least one lowercase letter');
        }

        if (!preg_match('/[0-9]/', $plainPassword)) {
            throw new LinkifyrValidationException('Password must contain at least one digit');
        }

        if (!preg_match('/[\W_]/', $plainPassword)) {
            throw new LinkifyrValidationException('Password must contain at least one special character');
        }

        $hashedPassword = password_hash($plainPassword, PASSWORD_DEFAULT);

        if (!$hashedPassword) {
            throw new LinkifyrValidationException('Failed to hash password');
        }

        return new self($hashedPassword);
    }

    public static function fromHash(string $hashedPassword): self
    {
        return new self($hashedPassword);
    }

    public function verify(string $plainPassword): bool
    {
        return password_verify($plainPassword, $this->password);
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function __toString(): string
    {
        return $this->password;
    }
}
