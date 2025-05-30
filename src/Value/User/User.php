<?php

declare(strict_types=1);

namespace LinkifyrApi\Value\User;

use DateTimeImmutable;
use DateTimeInterface;

class User
{
    private function __construct(
        private readonly string                $userId,
        private Username                    $username,
        private Email                       $email,
        private Password                    $password,
        private readonly DateTimeImmutable  $createdAt,
        private readonly ?DateTimeImmutable $updatedAt = null,
    ) {
    }

    public static function from(
        string $userId,
        Username $username,
        Email $email,
        Password $password,
        DateTimeImmutable $createdAt,
        ?DateTimeImmutable $updatedAt = null
    ): self {
        return new self(
            $userId,
            $username,
            $email,
            $password,
            $createdAt,
            $updatedAt
        );
    }

    public static function fromDatabase(array $data): self
    {
        return new self(
            $data['userId'],
            Username::from($data['username']),
            Email::from($data['email']),
            Password::fromHash($data['password']),
            new DateTimeImmutable($data['createdAt']),
            isset($data['updatedAt']) ? new DateTimeImmutable($data['updatedAt']) : null
        );
    }

    public function toArray(): array
    {
        return [
            'userId'    => $this->userId,
            'username'  => $this->username->value(),
            'email'     => $this->email->value(),
            'createdAt' => $this->createdAt->format(DateTimeInterface::ATOM),
            'updatedAt' => $this->updatedAt?->format(DateTimeInterface::ATOM),
        ];
    }

    public function equals(User $other): bool
    {
        return $this->userId === $other->userId;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function getUsername(): Username
    {
        return $this->username;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getPassword(): Password
    {
        return $this->password;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUsername(Username $username): void
    {
        $this->username = $username;
    }

    public function setEmail(Email $email): void
    {
        $this->email = $email;
    }

    public function setPassword(Password $password): void
    {
        $this->password = $password;
    }
}
