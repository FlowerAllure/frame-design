<?php

namespace Core\request;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;

class PHPRequest implements RequestInterface
{
    public function __construct(
        protected string $uri,
        protected string $method,
        protected array $headers,
    ) {
    }

    public static function create(string $uri, string $method, array $headers = []): static
    {
        return new static($uri, $method, $headers);
    }

    public function getProtocolVersion()
    {
        // TODO: Implement getProtocolVersion() method.
    }

    public function withProtocolVersion(string $version)
    {
        // TODO: Implement withProtocolVersion() method.
    }

    public function getHeaders()
    {
        // TODO: Implement getHeaders() method.
    }

    public function hasHeader(string $name)
    {
        // TODO: Implement hasHeader() method.
    }

    public function getHeader(string $name)
    {
        // TODO: Implement getHeader() method.
    }

    public function getHeaderLine(string $name)
    {
        // TODO: Implement getHeaderLine() method.
    }

    public function withHeader(string $name, $value)
    {
        // TODO: Implement withHeader() method.
    }

    public function withAddedHeader(string $name, $value)
    {
        // TODO: Implement withAddedHeader() method.
    }

    public function withoutHeader(string $name)
    {
        // TODO: Implement withoutHeader() method.
    }

    public function getBody()
    {
        // TODO: Implement getBody() method.
    }

    public function withBody(StreamInterface $body)
    {
        // TODO: Implement withBody() method.
    }

    public function getRequestTarget()
    {
        // TODO: Implement getRequestTarget() method.
    }

    public function withRequestTarget(string $requestTarget)
    {
        // TODO: Implement withRequestTarget() method.
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function withMethod(string $method)
    {
        // TODO: Implement withMethod() method.
    }

    public function getUri(): string
    {
        return $this->uri;
    }

    public function withUri(UriInterface $uri, bool $preserveHost = false)
    {
        // TODO: Implement withUri() method.
    }
}