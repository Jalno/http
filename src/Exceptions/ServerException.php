<?php

namespace Jalno\Http\Exceptions;

use Jalno\Http\Contracts\Exceptions\IServerException;

class ServerException extends ResponseException implements IServerException
{
}
