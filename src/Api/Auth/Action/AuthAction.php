<?php

declare(strict_types=1);

namespace LinkifyrApi\Api\Auth\Action;

use LinkifyrApi\Api\ApiAction;
use LinkifyrApi\Api\Auth\Service\AuthService;
use LinkifyrApi\Api\RequestValidator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class AuthAction extends ApiAction
{
    public function __construct(
        private readonly AuthService $authService,
        private readonly RequestValidator $validator,
    ) {
    }

    protected function execute(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $rules = [
            'email' => ['required' => true, 'location' => RequestValidator::LOCATION_BODY],
            'password' => ['required' => true, 'location' => RequestValidator::LOCATION_BODY],
        ];

        $this->validator->validate($request, $rules);

        return $this->authService->login($request, $response);
    }
}
