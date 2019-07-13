<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require 'vendor/autoload.php';

// Instantiate Slim App
$app = new \Slim\App([
    'settings' => [
        'displayErrorDetails' => true,
    ],
]);

// Get container
$container = $app->getContainer();

// Register component on container
$container['view'] = function ($container) {
    $view = new \Slim\Views\Twig('views');

    // Instantiate and add Slim specific extension
    $router = $container->get('router');
    $uri = \Slim\Http\Uri::createFromEnvironment(new \Slim\Http\Environment($_SERVER));
    $view->addExtension(new \Slim\Views\TwigExtension($router, $uri));

    return $view;
};

// App Settings
$container->get('view')->getEnvironment()->addGlobal('GENERICIZED', true);

// Register Twig Extensions
require 'extensions/variables.php';
require 'extensions/functions.php';

/**
 * Routes
 */
/** Home */
$app->get('/', function (Request $req,  Response $res, $args = []) {
    return $this->view->render($res, "layouts/table-of-contents.phtml", [
        'templates' => glob('views/templates/*.phtml'),
        'headers' => glob('views/components/header*.phtml'),
        'displays' => glob('views/displays/*.phtml'),
    ]);
});

/** Templates */
$app->get('/template/{filename}[/{header}]', function (Request $req,  Response $res, $args = []) {
    return $this->view->render($res, "templates/{$args['filename']}.phtml", [
        'filename' => $args['filename'],
        'header' => $args['header'] ?: 'header-logo-left-info-right',
    ]);
});

/** Displays */
$app->get('/display/{filename}', function (Request $req, Response $res, $args = []) {
    return $this->view->render($res, "displays/{$args['filename']}.phtml", [
        'filename' => $args['filename'],
    ]);
});

$app->run();
