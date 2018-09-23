<?php
require_once dirname(__DIR__) . '/config/init.php';

require_once LIBS . '/functions.php';
require_once CONF . '/routes.php';

$app = new \engine\App();

//debug(engine\Router::getRoutes());

//throw new Exception('404', 400);
