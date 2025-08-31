<?php
namespace Core;

class Router
{
  protected Request $request;
  protected Response $response;
  protected array $routes = [];
  protected array $route_params = [];
  protected ?array $current = null;
  protected array $params = [];

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
      'needToken' => true,
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
    $method = $this->request->getMethod();

    if(!$this->matchRoute($path, $method)) {
      http_response_code(404);
      return '404 Not Found';
    }

    $handler = $this->current['callback'];

    if(is_array($handler) && is_string($handler[0])) {
      $handler = [new $handler[0](), $handler[1]];
    }

    return call_user_func_array($handler, $this->params);
  }

  protected function matchRoute(string $path, string $method): bool
  {
    foreach ($this->routes as $route) {
      $methods = $route['methods'] ?? ($route['method'] ?? 'GET');
      $methods = array_map('strtoupper', (array)$methods);
      if (!in_array($method, $methods, true)) {
        continue;
      }

      $regex = '#^' . preg_replace('#\{([\w_]+)\}#', '(?P<$1>[^/]+)', $route['path']) . '$#';

      if(preg_match($regex, $path, $m)) {
        $this->current = $route;
        $this->params = [];
        foreach($m as $k => $v) {
          if (is_string($k)) $this->params[$k] = $v;
        }
        return true;
      }
    }
    return false;
  }
}