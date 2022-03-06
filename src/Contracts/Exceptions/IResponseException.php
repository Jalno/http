<?php

namespace Jalno\Http\Contracts\Exceptions;

use Jalno\Http\Contracts\IRequest;
use Jalno\Http\Contracts\IResponse;

interface IResponseException extends IException
{
    public function getRequest(): IRequest;

    public function getResponse(): IResponse;
}
