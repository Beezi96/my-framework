<?php
namespace Core;

class Request
{
  public string $uri;

  public function __construct($uri)
  {
    $this->uri = urldecode($uri);
  }

  public function getMethod(): string
  {
    return strtoupper($_SERVER["REQUEST_METHOD"] ?? 'GET');
  }

  public function isGet(): bool
  {
    return $this->getMethod() == 'GET';
  }

  public function isPost(): bool
  {
    return $this->getMethod() == 'POST';
  }

  public function isAjax(): bool
  {
    return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
  }

  public function get($name, $default = null): ?string
  {
    return $_GET[$name] ?? $default;
  }

  public function post($name, $default = null): ?string
  {
    return $_POST[$name] ?? $default;
  }

  public function getPath()
  {
    return $this->removeQueryString();
  }

  protected function removeQueryString(): string
  {
    $uri = $this->uri ?? '/';

    $qPos = strpos($uri, '?');
    $path = ($qPos === false) ? $uri : substr($uri, 0, $qPos);

    $path = '/' . trim($path, '/');

    return $path === '//' ? '/' : $path;
  }
}