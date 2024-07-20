<?php
require_once('_config.php');

use Yatzy\{Dice, YatzyGame, YatzyEngine, Leaderboard};

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

// Helper functions

function jsonReply(Response $response, $data) {
    $payload = json_encode($data);
    $response->getBody()->write($payload);
    return $response->withHeader('Content-Type', 'application/json; charset=utf-8');
}

function getScoreBoxesRegex() {
    return array_reduce(array_keys(YatzyEngine::getScoreBoxFunctions()), function($carry, $item) {
        $carry .= "|" . $item;
        return $carry;
    }, "");
}

// Game API calls

$app->get('/api/loadgame', function (Request $request, Response $response, $args) {
    global $game;
    $data = array(
        "rollNo" => $game->rollNo,
        "dice" => $game->dice,
        "keep" => $game->keep,
        "scoreBox" => YatzyGame::output_scores($game)
    );
    return jsonReply($response, $data);
});

$app->put('/api/roll', function (Request $request, Response $response, $args) {
    global $game;
    $data = $game->roll();
    return jsonReply($response, $data);
});

$app->put('/api/select/{id:[0-4]}', function (Request $request, Response $response, $args) {
    global $game;
    $data = $game->select(isset($args["id"]) ? intval($args["id"]) : null);
    return jsonReply($response, $data);
});

$app->put('/api/restart', function (Request $request, Response $response, $args) {
    global $game;
    $data = $game->restart();
    return jsonReply($response, $data);
});

$app->put('/api/score/{id:' . getScoreBoxesRegex() . '}', function (Request $request, Response $response, $args) {
    global $game;
    $data = $game->score(isset($args["id"]) ? $args["id"] : null);
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