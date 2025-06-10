<?php

declare(strict_types=1);

namespace LinkifyrApi\Api\Auth\Service;

use Fig\Http\Message\StatusCodeInterface;
use LinkifyrApi\Api\User\Repository\UserRepository;
use LinkifyrApi\Value\Result\ApiResult;
use LinkifyrApi\Value\Result\JsonResult;
use LinkifyrApi\Value\User\Email;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use ReallySimpleJWT\Token;

class AuthService
{
    public function __construct(
        private readonly UserRepository $repository,
    ) {
    }

    public function login(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $body = $request->getParsedBody();
        $email = Email::from($body['email']);
        $password = $body['password'];

        $user = $this->repository->findByEmail($email);

        if ($user === null) {
            return ApiResult::from(
                JsonResult::from(
                    'User not found',
                ),
                StatusCodeInterface::STATUS_NOT_FOUND
            )->getResponse($response);
        }

        if (!$user->getPassword()->verify($password)) {
            return ApiResult::from(
                JsonResult::from(
                    'Invalid password',
                ),
                StatusCodeInterface::STATUS_UNAUTHORIZED
            )->getResponse($response);
        }


        $expiresIn = time() + (int)getenv('JWT_NORMAL_EXPIRATION_TIME');
        $token = Token::builder(getenv('JWT_SECRET'))
            ->setIssuer('https://api.linkifyr.eu/')
            ->setPayloadClaim('email', $user->getEmail()->value())
            ->setPayloadClaim('sub', $user->getUserId()->value())
            ->setIssuedAt(time())
            ->setExpiration($expiresIn)
            ->build();

        return ApiResult::from(
            JsonResult::from(
                'Login successful',
                [
                    'token' => $token,
                    'user' => $user->toArray(),
                ]
            ),
        )->getResponse($response);
    }
}
