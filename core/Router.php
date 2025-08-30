<?php
namespace Core;

class Router
{
  protected Request $request;
  protected Response $response;
  protected array $routes = [];
  protected array $route_params = [];

  public function __construct(Request $request, Response $response)
  {
    $this->request = $request;
    $this->response = $response;
  }

  public function add($path, $callback, $method): self
  {
    $path = trim($path, '/');
    if(is_array($method)) {
      $method = array_map('strtoupper', $method);
    } else {
      $method = [strtoupper($method)];
    }
    $this->routes[] = [
      'path' => "/$path",
      'callback' => $callback,
      'middleware' => null,
      'method' => $method,
    ];
    return $this;
  }

  public function get($path, $callback): self
  {
    return $this->add($path, $callback, 'GET');
  }

  public function post($path, $callback): self
  {
    return $this->add($path, $callback, 'POST');
  }

  public function getRoutes(): array
  {
    return $this->routes;
  }

  public function dispatch(): mixed
  {
    $path = $this->request->getPath();
    $route = $this->matchRoute($path);
    return '';
  }

  protected function matchRoute($path)
  {
    foreach($this->routes as $route){
      if (
        preg_match("#^{$route['path']}$#", "{$path}", $matches)
        &&
        in_array($this->request->getMethod(), $route['method'])
      ) {
        dump($matches);
        dump($route);
        dump($this->request->getMethod());
        dump($this->route_params);
        foreach ($matches as $k => $v) {
          if (is_string($k)){
            $this->route_params[$k] = $v;
          }
        }
        dump($this->route_params);
      }
    }
  }
}