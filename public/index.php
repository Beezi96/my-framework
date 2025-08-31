<?php



require_once __DIR__ . '/../config/config.php';
require_once ROOT . '/vendor/autoload.php';
require_once HELPERS . '/helpers.php';

$app = new \Core\Application();
require_once CONFIG . '/routes.php';
echo $app->router->dispatch();
// $app->run();
// dump($app);
// dump(app());
// dump(request()->getMethod());
// dump(request()->isGet());
// dump(request()->isPost());
// dump(request()->isAjax());
// dump(request()->get('page', 10));

