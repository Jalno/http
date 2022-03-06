<?php

namespace Jalno\Http;

use dnj\Filesystem\Contracts\IFile;
use Jalno\Http\Contracts\IHandler;
use Jalno\Http\Contracts\IRequest;
use Jalno\Http\Exceptions\Exception;

/**
 * @phpstan-import-type Options from IHandler
 * @phpstan-import-type ProxyOptions from IHandler
 */
class Request implements IRequest
{
    public static function fromURL(string $url): self
    {
        $components = parse_url($url);
        if (false === $components) {
            throw new Exception('Cannot parse url');
        }
        if (!isset($components['host'])) {
            throw new Exception("Cannot find 'host' in url");
        }
        $request = new self($components['host'], $components['path'] ?? '');
        if (isset($components['scheme'])) {
            $request->setScheme($components['scheme']);
        }
        if (isset($components['port'])) {
            $request->setPort($components['port']);
        }
        if (isset($components['query']) and $components['query']) {
            parse_str($components['query'], $query);
            $request->setQuery($query);
        }

        return $request;
    }

    /**
     * @param Options $options
     */
    public static function fromOptions(string $method, string $url, array $options): self
    {
        $url = self::buildURL($url, $options);
        $request = self::fromURL($url);
        $request->setMethod($method);
        if (isset($options['body'])) {
            $request->setBody($options['body']);
        }
        if (isset($options['headers']) and is_array($options['headers'])) {
            $request->setHeaders($options['headers']);
        }
        if (isset($options['proxy'])) {
            $request->setProxy($options['proxy']);
        }
        if (isset($options['save_as'])) {
            $request->saveAs($options['save_as']);
        }
        if (isset($options['outgoing_ip'])) {
            $request->setOutgoingIP($options['outgoing_ip']);
        }
        if (isset($options['query'])) {
            $request->setQuery(array_replace_recursive($request->query, $options['query']));
        }

        return $request;
    }

    /**
     * @param Options $options
     */
    protected static function buildURL(string $URI, array $options): string
    {
        if (preg_match("/^[a-z]+\:\/\//i", $URI)) {
            return $URI;
        }
        if (!isset($options['base_uri'])) {
            throw new Exception("'base_uri' is necessary");
        }

        return rtrim($options['base_uri'], '/').'/'.ltrim($URI, '/');
    }

    protected string $method = 'GET';
    protected string $uri;
    protected string $scheme = 'http';
    protected ?string $ip = null;
    protected string $host;
    protected ?int $port = null;

    /**
     * @var array<string,string>
     */
    protected array $headers = [];

    /**
     * @var array<string,mixed>
     */
    protected array $query = [];

    /**
     * @var string|array<string,mixed>|IFile|null
     */
    protected $body = null;

    /**
     * @var ProxyOptions|null
     */
    protected ?array $proxy = null;
    protected ?IFile $outputFile = null;
    protected ?string $outgoingIP = null;

    public function __construct(string $host, string $uri)
    {
        $this->setHost($host);
        $this->setURI($uri);
    }

    public function setMethod(string $method): void
    {
        $this->method = strtoupper($method);
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function setHost(string $host): void
    {
        $this->host = $host;
    }

    public function getHost(): string
    {
        return $this->host;
    }

    public function setURI(string $uri): void
    {
        $this->uri = ltrim($uri, '/');
    }

    public function getURI(): string
    {
        return $this->uri;
    }

    public function setQuery(array $query): void
    {
        $this->query = $query;
    }

    public function getQuery(): array
    {
        return $this->query;
    }

    public function getURL(): string
    {
        $url = $this->scheme.'://'.$this->host;
        if ($this->port) {
            $url .= ':'.$this->port;
        }
        $url .= '/'.$this->uri;
        if ($this->query) {
            $url .= '?'.http_build_query($this->query);
        }

        return $url;
    }

    public function setScheme(string $scheme): void
    {
        $this->scheme = $scheme;
    }

    public function getScheme(): string
    {
        return $this->scheme;
    }

    public function setPort(?int $port): void
    {
        $this->port = $port;
    }

    public function getPort(): ?int
    {
        return $this->port;
    }

    public function setIP(?string $ip): void
    {
        $this->ip = $ip;
    }

    public function getIP(): ?string
    {
        return $this->ip;
    }

    public function setReferer(?string $referer): void
    {
        $this->setHeader('Referer', $referer);
    }

    public function getReferer(): ?string
    {
        return $this->getHeader('Referer');
    }

    public function setHeader(string $name, ?string $value): void
    {
        if (null === $value) {
            unset($this->headers[$name]);

            return;
        }
        $this->headers[$name] = $value;
    }

    public function getHeader(string $name): ?string
    {
        return $this->headers[$name] ?? null;
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

    public function setBody($body): void
    {
        $this->body = $body;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function setProxy(?array $proxy): void
    {
        $this->proxy = $proxy;
    }

    public function getProxy(): ?array
    {
        return $this->proxy;
    }

    public function saveAs(?IFile $file): void
    {
        $this->outputFile = $file;
    }

    public function getSaveAs(): ?IFile
    {
        return $this->outputFile;
    }

    public function setOutgoingIP(?string $outgoingIP): void
    {
        $this->outgoingIP = $outgoingIP;
    }

    public function getOutgoingIP(): ?string
    {
        return $this->outgoingIP;
    }
}
