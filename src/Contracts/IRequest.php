<?php

namespace Jalno\Http\Contracts;

use dnj\Filesystem\Contracts\IFile;

/**
 * @phpstan-import-type ProxyOptions from IHandler
 */
interface IRequest
{
    public function setMethod(string $method): void;

    public function getMethod(): string;

    public function setHost(string $host): void;

    public function getHost(): string;

    public function setURI(string $uri): void;

    public function getURI(): string;

    /**
     * @param array<string,mixed> $query
     */
    public function setQuery(array $query): void;

    /**
     * @return array<string,mixed>
     */
    public function getQuery(): array;

    public function getURL(): string;

    public function setScheme(string $scheme): void;

    public function getScheme(): string;

    public function setPort(?int $port): void;

    public function getPort(): ?int;

    public function setIP(?string $ip): void;

    public function getIP(): ?string;

    public function setHeader(string $name, ?string $value): void;

    public function getHeader(string $name): ?string;

    /**
     * @param array<string,string> $headers
     */
    public function setHeaders(array $headers): void;

    /**
     * @return array<string,string>
     */
    public function getHeaders(): array;

    /**
     * @param string|array<string,mixed>|IFile|null $body
     */
    public function setBody($body): void;

    /**
     * @return string|array<string,mixed>|IFile|null
     */
    public function getBody();

    /**
     * @param ProxyOptions|null $proxy
     */
    public function setProxy(?array $proxy): void;

    /**
     * @return ProxyOptions|null
     */
    public function getProxy(): ?array;

    public function saveAs(?IFile $file): void;

    public function getSaveAs(): ?IFile;

    public function setOutgoingIP(?string $outgoingIP): void;

    public function getOutgoingIP(): ?string;
}
