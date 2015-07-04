<?php

require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/../src/OAuth2Demo/Server/Server.php';
require_once __DIR__.'/../src/OAuth2Demo/Server/Models/UserCredentials.php';
require_once __DIR__.'/../src/OAuth2Demo/Server/Controllers/Token.php';
require_once __DIR__.'/../src/OAuth2Demo/Server/Controllers/CheckAuthorize.php';

/** set up the silex application object */
$app = new Silex\Application();
$app->register(new Silex\Provider\UrlGeneratorServiceProvider());
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views',
));

/** set up routes / controllers */
$app->mount('/', new OAuth2Demo\Server\Server());

// create an http foundation request implementing OAuth2\RequestInterface
$request = OAuth2\HttpFoundationBridge\Request::createFromGlobals();
$app->run($request);
