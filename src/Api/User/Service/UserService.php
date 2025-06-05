<?php

declare(strict_types=1);

namespace LinkifyrApi\Api\User\Service;

use DateTimeImmutable;
use LinkifyrApi\Api\User\Repository\UserRepository;
use LinkifyrApi\Exception\LinkifyrUserAlreadyExistsException;
use LinkifyrApi\Value\Result\ApiResult;
use LinkifyrApi\Value\Result\JsonResult;
use LinkifyrApi\Value\User\Email;
use LinkifyrApi\Value\User\Password;
use LinkifyrApi\Value\User\User;
use LinkifyrApi\Value\User\UserId;
use LinkifyrApi\Value\User\Username;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class UserService
{
    public function __construct(
        private readonly UserRepository $userRepository,
    ) {
    }

    public function create(ServerRequestInterface $request, ResponseInterface $response): ApiResult
    {
        $body = $request->getParsedBody();
        $username = $body['username'];
        $email = $body['email'];
        $password = $body['password'];

        try {

        } catch (LinkifyrUserAlreadyExistsException $e) {
            return ApiResult::from(
                JsonResult::from($e->getMessage(), $e->getCode()),
            );
        }

        $user = User::from(
            UserId::generate(),
            Username::from($username),
            Email::from($email),
            Password::fromPlain($password),
            new DateTimeImmutable(),
        );

        $this->userRepository->create($user);

        return ApiResult::from(
            JsonResult::from(
                'User created successfully',
                [
                    'user' => $user->toArray(),
                ]
            )
        );
    }
}
