<?php

namespace Jalno\Http\Exceptions;

use Jalno\Http\Contracts\Exceptions\IResponseException;
use Jalno\Http\Contracts\IRequest;
use Jalno\Http\Contracts\IResponse;

class ResponseException extends Exception implements IResponseException
{
    protected IRequest $request;
    protected IResponse $response;

    public function __construct(
        IRequest $request,
        IResponse $response,
        string $message = '',
        int $code = 0,
        ?\Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
        $this->request = $request;
        $this->response = $response;
    }

    public function getRequest(): IRequest
    {
        return $this->request;
    }

    public function getResponse(): IResponse
    {
        return $this->response;
    }
}
