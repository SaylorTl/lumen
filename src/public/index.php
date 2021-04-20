<?php
/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| First we need to get an application instance. This creates an instance
| of the application / container and bootstraps the application so it
| is ready to receive HTTP / Console requests from the environment.
|
*/

use App\Libraries\LumenTracer;

$app = require __DIR__.'/../bootstrap/app.php';

define('BASE_PATH', realpath(dirname(__FILE__) . '/..'));
define('PUBLIC_PATH', BASE_PATH.'/public');

/*
|--------------------------------------------------------------------------
| Run The Application
|--------------------------------------------------------------------------
|
| Once we have the application, we can handle the incoming request
| through the kernel, and send the associated response back to
| the client's browser allowing them to enjoy the creative
| and wonderful application we have prepared for them.
|
*/
LumenTracer::setTracer(); //启动jaegertracing
$app->run();
