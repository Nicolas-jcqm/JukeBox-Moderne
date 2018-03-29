<?php

/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 19/02/2018
 * Time: 13:29
 */

include_once 'vendor/autoload.php';

use Controllers\JukeboxController;
use Controllers\AdminController;
use Controllers\QueueContentController;
use Controllers\JukeboxLibraryController;
use conf\Eloquent;

Eloquent::init('src/conf/config.ini');

$app = new Slim\App([
    'settings' => [
        'displayErrorDetails' => true
    ]
]);

$middleware_co = function (Slim\Http\Request $request, Slim\Http\Response $response, $next) {
    $token = $request->getAttribute('token');
    if(isset($_SESSION['token']) && $_SESSION['token'] == $token){
        return $next($request, $response);
    }else {
        return $response->withJson(['Wrong token' => 'can t connect'], 401);
    }
};

$app->add(function(Slim\Http\Request $request, Slim\Http\Response $response, callable $next){
	$response = $response->withHeader('Content-type', 'application/json; charset=utf-8');
	$response = $response->withHeader('Access-Control-Allow-Origin', '*');
	$response = $response->withHeader('Access-Control-Allow-Methods', 'OPTION, GET, POST, PUT, PATCH, DELETE');
    $response = $response->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization');
	return $next($request, $response);
});

$app->post('/jukebox/library/track',function (Slim\Http\Request $req,  Slim\Http\Response $res, $args)  use ($app){
    $jlc = new JukeboxLibraryController();
    return $jlc->addTrackIntoLibrary($req, $res);
});

$app->post('/jukebox/queue/track',function (Slim\Http\Request $req,  Slim\Http\Response $res, $args)  use ($app){
    $qcc = new QueueContentController();
    return $qcc->addTrackIntoQueue($req, $res);
});

$app->get('/jukebox/{tokenJukebox}',function (Slim\Http\Request $req,  Slim\Http\Response $res, $args)  use ($app){
    $jc = new JukeboxController();
    echo $jc->returnJukebox($args['tokenJukebox']);
});

$app->get('/jukebox/{tokenJukebox}/queues',function(Slim\Http\Request $req,  Slim\Http\Response $res, $args) use ($app){
    $jc = new JukeboxController();
    echo $jc->returnQueues($args['tokenJukebox']);
});

$app->get('/jukebox/{tokenJukebox}/queue/tracks',function(Slim\Http\Request $req,  Slim\Http\Response $res, $args) use ($app){
    $jc = new JukeboxController();
    echo $jc->returnTracks($args['tokenJukebox']);
});
//Creation d'un jukebox
$app->post('/jukebox', function(Slim\Http\Request $req,  Slim\Http\Response $res, $args) use ($app){
    $jc = new JukeboxController();
    return $jc->addJukeBox($req, $res);
});

$app->post('/admin/signin',function(Slim\Http\Request $req,  Slim\Http\Response $res, $args) use ($app){
    $ac = new AdminController();
    return $ac->Signin($req, $res);
});

$app->post('/admin/signup',function(Slim\Http\Request $req,  Slim\Http\Response $res, $args) use ($app){
    $ac = new AdminController();
    return $ac->Signup($req, $res);
});

$app->get('/admin/logout',function(Slim\Http\Request $req,  Slim\Http\Response $res, $args) use ($app){
    $ac = new AdminController();
    return $ac->disconnect($req, $res);
});

$app->run();
