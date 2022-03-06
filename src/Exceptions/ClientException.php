<?php

namespace Jalno\Http\Exceptions;

use Jalno\Http\Contracts\Exceptions\IClientException;

class ClientException extends ResponseException implements IClientException
{
}
