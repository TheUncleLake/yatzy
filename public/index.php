<?php
require_once('_config.php');

use Yatzy\{Dice, YatzyGame, Leaderboard};

session_start();

if (!isset($_SESSION["leaderboard"])) {
    $_SESSION["leaderboard"] = array();
}

$game = new YatzyGame();
if (!isset($_SESSION["game"])) {
    $_SESSION["game"] = array(
        "rollNo" => &$game->rollNo,
        "dice" => &$game->dice,
        "keep" => &$game->keep,
        "scoreBox" => &$game->scoreBox
    );
} else {
    $game->rollNo = &$_SESSION["game"]["rollNo"];
    $game->dice = &$_SESSION["game"]["dice"];
    $game->keep = &$_SESSION["game"]["keep"];
    $game->scoreBox = &$_SESSION["game"]["scoreBox"];
}

// Set up app

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

$app = AppFactory::create();

// Helper functions

function jsonReply(Response $response, $data) {
    $payload = json_encode($data);
    $response->getBody()->write($payload);
    return $response->withHeader('Content-Type', 'application/json; charset=utf-8');
}

// General API calls

$app->get('/', function (Request $request, Response $response, $args) {
    $view = file_get_contents("{$GLOBALS["appDir"]}/views/index.html");
    $response->getBody()->write($view);
    return $response;
});

$app->get('/script', function (Request $request, Response $response, $args) {
    $view = file_get_contents("{$GLOBALS["appDir"]}/views/script.js");
    $response->getBody()->write($view);
    return $response->withHeader('Content-Type', 'text/javascript');
});

$app->get('/styles', function (Request $request, Response $response, $args) {
    $view = file_get_contents("{$GLOBALS["appDir"]}/views/styles.css");
    $response->getBody()->write($view);
    return $response->withHeader('Content-Type', 'text/css');
});

// Game API calls

$app->get('/api/loadgame', function (Request $request, Response $response, $args) {
    return jsonReply($response, $_SESSION["game"]);
});

$app->get('/api/roll', function (Request $request, Response $response, $args) {
    $d = new Dice();
    $data = ["value" => $d->roll()];
    return jsonReply($response, $data);
});

$app->get('/api/leaderboard', function (Request $request, Response $response, $args) {
    if (count($_SESSION["leaderboard"]) < 1) { // For testing purposes
        $d = new Dice(0, 374);
        Leaderboard::add($_SESSION["leaderboard"], $d->roll());
    } else {
        $_SESSION["leaderboard"] = array();
    }
    $data = ["leaderboard" => $_SESSION["leaderboard"]];
    return jsonReply($response, $data);
});

$app->run();