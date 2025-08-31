<?php
/** @var \Core\Application $app */
use App\Controllers\HomeController;

$app->router->add('/', function() {
  return 'Hello from home';
}, ['post', 'get']);

$app->router->get('/test', fn() => 'OK');

$app->router->get('/hello/{name}', [HomeController::class, 'hello']);

$app->router->post('/contact', [HomeController::class, 'contact']);

$app->router->get('/post/{slug}', function(string $slug) {
  return '<p>Post: ' . htmlspecialchars($slug, ENT_QUOTES, 'UTF-8') . '</p>';
});

// dump($app->router->getRoutes());