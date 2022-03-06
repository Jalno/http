<?php

namespace Jalno\Http;

use dnj\Filesystem\Contracts\IFile;
use Jalno\Http\Contracts\IResponse;

class Response implements IResponse
{
    private int $statusCode;
    private ?string $primaryIP = null;

    /**
     * @var array<string,string>
     */
    private array $headers = [];
    private ?string $body = null;
    private ?IFile $file = null;

    /**
     * @param array<string,string> $headers
     */
    public function __construct(int $status = 200, array $headers = [])
    {
        $this->setStatusCode($status);
        $this->setHeaders($headers);
    }

    public function setStatusCode(int $status): void
    {
        $this->statusCode = $status;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function setHeader(string $name, string $value): void
    {
        $this->headers[strtolower($name)] = $value;
    }

    public function getHeader(string $name): ?string
    {
        $name = strtolower($name);

        return isset($this->headers[$name]) ? $this->headers[$name] : null;
    }

    public function setHeaders(array $headers): void
    {
        foreach ($headers as $name => $value) {
            $this->setHeader($name, $value);
        }
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function setBody(?string $body): void
    {
        $this->body = $body;
    }

    public function getBody(): ?string
    {
        if ($this->file) {
            return $this->file->read();
        }

        return $this->body;
    }

    public function setFile(?IFile $file): void
    {
        $this->file = $file;
    }

    public function getFile(): ?IFile
    {
        return $this->file;
    }

    public function setPrimaryIP(?string $ip): void
    {
        $this->primaryIP = $ip;
    }

    public function getPrimaryIP(): ?string
    {
        return $this->primaryIP;
    }
}
