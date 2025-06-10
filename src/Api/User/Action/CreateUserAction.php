<?php

declare(strict_types=1);

namespace LinkifyrApi\Api\User\Action;

use LinkifyrApi\Api\ApiAction;
use LinkifyrApi\Api\RequestValidator;
use LinkifyrApi\Api\User\Service\UserService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class CreateUserAction extends ApiAction
{
    public function __construct(
        private readonly UserService $service,
        private readonly RequestValidator $validator,
    ) {
    }

    protected function execute(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $rules = [
            'username' => ['required' => true, 'location' => RequestValidator::LOCATION_BODY],
            'email' => ['required' => true, 'location' => RequestValidator::LOCATION_BODY],
            'password' => ['required' => true, 'location' => RequestValidator::LOCATION_BODY],
        ];

        $this->validator->validate($request, $rules);

        return $this->service->create($request, $response);
    }
}
