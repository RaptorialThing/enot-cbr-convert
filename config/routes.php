<?php

use App\Router;
use App\Controllers\DashboardController;

$router = new Router($_SERVER);

$router->addRoute('/hello', function() {
    echo "Hello, " . ucfirst($this->get['name']);
});

$router->addRoute('/register', function() {
    return (new DashboardController())->register();
});

$router->addRoute('/login', function() {
    return (new DashboardController())->login();
});

$router->addRoute('/logout', function() {
    return (new DashboardController())->logout();
});

$router->addRoute('/', function() {
    return (new DashboardController())->index();
});

$router->addRoute('/curl_currencies', function() {
    return (new DashboardController())->curl_currencies();
});

$router->run();
