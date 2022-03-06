<?php

namespace Jalno\Http\Contracts;

use dnj\Filesystem\Contracts\IFile;

interface IResponse
{
    public function setStatusCode(int $status): void;

    public function getStatusCode(): int;

    public function setHeader(string $name, string $value): void;

    public function getHeader(string $name): ?string;

    /**
     * @param array<string,string> $headers
     */
    public function setHeaders(array $headers): void;

    /**
     * @return array<string,string>
     */
    public function getHeaders(): array;

    public function setBody(?string $body): void;

    public function getBody(): ?string;

    public function setFile(?IFile $file): void;

    public function getFile(): ?IFile;

    public function setPrimaryIP(?string $ip): void;

    public function getPrimaryIP(): ?string;
}
