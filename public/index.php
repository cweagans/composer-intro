<?php

require_once __DIR__ . "/../vendor/autoload.php";
require_once __DIR__ . "/../includes/config.inc";

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use cweagans\Habitat\Controllers\PageController;
use cweagans\Habitat\Controllers\ThermostatController;
use cweagans\Habitat\Controllers\UserController;

// Set up Twig.
$loader = new Twig_Loader_Filesystem(__DIR__ . "/../src/Views");
$twig = new Twig_Environment($loader, array('debug' => true));
$twig->addExtension(new Twig_Extension_Debug());

// Create the router.
$router = new League\Route\RouteCollection();

// Set up the routes for the application.
$router->addRoute('GET', '/', function (Request $request, Response $response) use ($twig) {
  $controller = new PageController($twig);
  $response->setContent($controller->homePage());
  return $response;
});

$router->addRoute('GET', '/about', function (Request $request, Response $response) use ($twig) {
  $controller = new PageController($twig);
  $response->setContent($controller->aboutPage());
  return $response;
});

$router->addRoute('GET', '/user/login', function (Request $request, Response $response) use ($twig) {
  $controller = new UserController($twig);
  $response->setContent($controller->loginPage());
  return $response;
});

$router->addRoute('POST', '/user/login', function (Request $request, Response $response) use ($twig) {
  $controller = new UserController($twig);
  $output = $controller->loginSubmit();
  if (is_string($output)) {
    $response->setContent($output);
  }
  if ($output instanceof Response) {
    $response = $output;
  }

  return $response;
});

$router->addRoute('GET', '/user/logout', function (Request $request, Response $response) use ($twig) {
  $controller = new UserController($twig);
  return $controller->logout();
});

$router->addRoute('GET', '/admin/thermostat', function (Request $request, Response $response) use ($twig, $config) {
  $controller = new ThermostatController($twig, $config);
  $response->setContent($controller->thermostatPage());
  return $response;
});

$router->addRoute('POST', '/admin/thermostat', function (Request $request, Response $response) use ($twig, $config) {
  $controller = new ThermostatController($twig, $config);
  $response->setContent($controller->setThermostat());
  return $response;
});

// Now, hand the request off to the dispatcher and let it do it's thing.
$dispatcher = $router->getDispatcher();
$request = Request::createFromGlobals();

$response = $dispatcher->dispatch($request->getMethod(), $request->getPathInfo());
$response->send();
