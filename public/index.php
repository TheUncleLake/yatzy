<?php
require_once('_config.php');

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

use Yatzy\Dice;

$app = AppFactory::create();

function jsonReply(Response $response, $data)
{
    $payload = json_encode($data);
    $response->getBody()->write($payload);
    return $response->withHeader('Content-Type', 'application/json');
}

$app->get('/', function (Request $request, Response $response, $args) {
    $view = file_get_contents("{$GLOBALS["appDir"]}/views/index.html");
    $response->getBody()->write($view);
    return $response;
});

$app->get('/api/version', function (Request $request, Response $response, $args) {
    $data = ["version" => "1.0"];
    return jsonReply($response, $data);
});

$app->get('/api/roll', function (Request $request, Response $response, $args) {
    $d = new Dice();
    $data = ["value" => $d->roll()];
    return jsonReply($response, $data);
});

$app->run();