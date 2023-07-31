<?php

namespace Core;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class Response implements ResponseInterface
{
    protected array $headers = []; // 要发送的请求头
    protected string|null $content; // 要发送的内容
    protected int $code = 200; // 发送状态码

    public function sendHeaders(): void // 发送请求头
    {
        foreach ($this->headers as $key => $header) {
            header($key . ': ' . $header);
        }
    }

    public function sendContent(): void // 发送内容
    {
        echo $this->content . PHP_EOL;
    }

    public function send(): static // 发送
    {
        $this->sendHeaders();
        $this->sendContent();

        return $this;
    }

    public function setContent($content): static // 设置内容
    {
        if (is_array($content)) {
            $content = json_encode($content);
        }

        $this->content = $content;

        return $this;
    }

    public function getContent(): string // 获取内容
    {
        return $this->content;
    }

    public function setCode(int $code): static // 设置状态码
    {
        $this->code = $code;

        return $this;
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

    public function getStatusCode()
    {
        // TODO: Implement getStatusCode() method.
    }

    public function withStatus(int $code, string $reasonPhrase = '')
    {
        // TODO: Implement withStatus() method.
    }

    public function getReasonPhrase()
    {
        // TODO: Implement getReasonPhrase() method.
    }
}
