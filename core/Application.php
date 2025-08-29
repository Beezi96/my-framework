<?php
namespace Core;


class Application
{
  protected string $uri;
  public Request $request;
  public Response $response;
  public Router $router;
  public static Application $app;

  public function __construct()
  {
    self::$app = $this;
    $path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
    $this->uri = rtrim($path, '/') ?: '/';
    $this->request = new Request($this->uri);
    $this->response = new Response();
    $this->router = new Router($this->request, $this->response);
    // var_dump($this->uri);
  }

  public function run(): void
  {
    echo $this->router->dispatch();
  }
}