<?php

declare(strict_types=1);

namespace LinkifyrApi\Api;

use LinkifyrApi\Exception\LinkifyrException;
use LinkifyrApi\Value\Result\ApiResult;
use LinkifyrApi\Value\Result\ErrorResult;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Throwable;

abstract class ApiAction
{
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
    ): ResponseInterface {
        try {
            $response = $this->execute($request, $response);
        } catch (LinkifyrException $exception) {
            $result = ApiResult::from(
                ErrorResult::from($exception),
                $exception->getCode()
            );

            return $result->getResponse($response);
        } catch (Throwable $exception) {
            $result = ApiResult::from(
                ErrorResult::from($exception),
                500
            );

            return $result->getResponse($response);
        }

        return $response;
    }

    abstract protected function execute(
        ServerRequestInterface $request,
        ResponseInterface $response
    ): ResponseInterface;
}
