<?php
namespace Core;


class Application
{
  protected string $uri;
  public Request $request;
  public static Application $app;

  public function __construct()
  {
    self::$app = $this;
    $path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
    $this->uri = rtrim($path, '/') ?: '/';
    $this->request = new Request($this->uri);
    // var_dump($this->uri);
  }
}