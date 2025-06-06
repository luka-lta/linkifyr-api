<?php

declare(strict_types=1);

namespace LinkifyrApi\Api\User\Repository;

use LinkifyrApi\Exception\LinkifyrDatabaseException;
use LinkifyrApi\Exception\LinkifyrUserAlreadyExistsException;
use LinkifyrApi\Value\User\User;
use PDO;
use PDOException;

class UserRepository
{
    public function __construct(
        private readonly PDO $pdo,
    ) {
        $this->pdo->beginTransaction();
    }

    public function create(User $user): void
    {
        $sql = <<<SQL
            INSERT INTO 
                users 
                (user_id, username, email, password_hash, created_at, updated_at) 
            VALUES 
                (:userId, :username, :email, :passwordHash, :createdAt, :updatedAt)
        SQL;

        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                'userId'       => $user->getUserId(),
                'username'     => $user->getUsername(),
                'email'        => $user->getEmail(),
                'passwordHash' => $user->getPassword(),
                'createdAt'    => $user->getCreatedAt()->format('Y-m-d H:i:s'),
                'updatedAt'    => $user->getUpdatedAt()?->format('Y-m-d H:i:s'),
            ]);
            $this->pdo->commit();
        } catch (PDOException $exception) {
            $this->pdo->rollBack();

            if ($exception->getCode() === '23000') {
                throw new LinkifyrUserAlreadyExistsException(
                    'User with this username or email already exists',
                    previous: $exception
                );
            }

            throw new LinkifyrDatabaseException(
                'Failed to create user: ' . $exception->getMessage(),
                previous: $exception
            );
        }
    }
}
