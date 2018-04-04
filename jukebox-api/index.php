<?php

/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 19/02/2018
 * Time: 13:29
 */

session_start();

include_once 'vendor/autoload.php';

use Controllers\AdminController;
use Controllers\JukeboxController;
use Controllers\JukeboxLibraryController;
use Controllers\LibraryController;
use Controllers\QueueContentController;
use Controllers\TrackController;
use conf\Eloquent;

Eloquent::init('src/conf/config.ini');

$app = new Slim\App([
    'settings' => [
        'displayErrorDetails' => true
    ]
]);

$app->add(function(Slim\Http\Request $request, Slim\Http\Response $response, callable $next){
    $response = $response->withHeader('Access-Control-Allow-Origin', 'http://localhost:8080');
    $response = $response->withHeader('Access-Control-Allow-Credentials', 'true');
	$response = $response->withHeader('Content-type', 'application/json; charset=utf-8');
	$response = $response->withHeader('Access-Control-Allow-Methods', 'OPTION, GET, POST, PUT, PATCH, DELETE');
    $response = $response->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization');
	return $next($request, $response);
});

$middleware_co = function (Slim\Http\Request $request, Slim\Http\Response $response, $next) {
    if(isset($_GET['token'])){
        $tokenReq = $_GET['token'];
    }
    if(isset($_SESSION['token'])){
        if($_SESSION['token'] == $tokenReq){
            return $next($request, $response);
        }else {
            return $response->withJson(['Wrong token' => 'can t connect'], 401);
        }
    }else {
        return $response->withJson(['No token' => 'can t connect'], 401);
    }
};

/**
 * Retourne un jukebox à partir de son token
 */
$app->get('/jukebox/{tokenJukebox}',function (Slim\Http\Request $req,  Slim\Http\Response $res, $args)  use ($app){
    $jc = new JukeboxController();
    $jukebox = $jc->returnJukebox($args['tokenJukebox']);
    if($jukebox == null) return json_encode(array('error'=>'token unknown'));
    else echo $jukebox;
});

/**
 * Retourne le token d'un jukebox à partir de son Id
 */
$app->get('/jukebox/token/{id}',function (Slim\Http\Request $req,  Slim\Http\Response $res, $args)  use ($app){
    $jc = new JukeboxController();
    echo $jc->returnJukeboxToken($args['id']);
});

/**
 * Retourne le jukebox de l'administrateur donné
 */
$app->get('/jukeboxs/{administratorJukebox}',function (Slim\Http\Request $req,  Slim\Http\Response $res, $args)  use ($app){
    $jc = new JukeboxController();
    echo $jc->returnJukeboxAdmin($args['administratorJukebox']);
});

/**
 * Retourne la queue à lire d'un jukebox donné
 */
$app->get('/jukebox/{tokenJukebox}/queues',function(Slim\Http\Request $req,  Slim\Http\Response $res, $args) use ($app){
    $jc = new JukeboxController();
    echo $jc->returnQueues($args['tokenJukebox']);
});

/**
 * Ajouter une musique du catalogue dans la bibliothèque
 * a besoin de tokenJukebox et idTrack
 */
$app->post('/jukebox/library/track',function (Slim\Http\Request $req,  Slim\Http\Response $res, $args)  use ($app){
    $jlc = new JukeboxLibraryController();
    return $jlc->addTrackIntoLibrary($req, $res);
});

/**
 * Ajoute une musique de la bibliotheque du jukebox dans la queue à lire (playlist)
 * a besoin de tokenJukebox, idTrack et userTrack : indiquant qui a ajouté cette musique
 */
$app->post('/jukebox/queue/track',function (Slim\Http\Request $req,  Slim\Http\Response $res, $args)  use ($app) {
    $qcc = new QueueContentController();
    return $qcc->addTrackIntoQueue($req, $res);
});

$app->put('/jukebox/queue/track/vote',function(Slim\Http\Request $req,  Slim\Http\Response $res, $args) use ($app){
    $jc = new QueueContentController();
    return $jc->vote($req, $res);
});

$app->put('/jukebox/queue/track/status',function(Slim\Http\Request $req,  Slim\Http\Response $res, $args) use ($app){
    $jc = new QueueContentController();
    return $jc->refreshStatusTrack($req, $res);
});

$app->get('/jukebox/{tokenJukebox}/queue/tracks',function(Slim\Http\Request $req,  Slim\Http\Response $res, $args) use ($app){
    $jc = new JukeboxController();
    echo $jc->returnTracks($args['tokenJukebox']);
});

//Creation d'un jukebox
$app->post('/jukebox', function(Slim\Http\Request $req,  Slim\Http\Response $res, $args) use ($app){
    $jc = new JukeboxController();
    return $jc->addJukeBox($req, $res);
})->add($middleware_co);

//Afficher le catalogue
$app->get('/trackCatalog', function(Slim\Http\Request $req,  Slim\Http\Response $res, $args) use ($app){
    $jc = new TrackController();
    echo $jc->returnTrackCatalog();
})->add($middleware_co);

//Afficher la bibliothèque d'un jukebox
$app->get('/jukebox/{tokenJukebox}/library/tracks', function(Slim\Http\Request $req,  Slim\Http\Response $res, $args) use ($app){
    $lc = new LibraryController();
    echo $lc->returnLibraryTracks($args['tokenJukebox']);
})->add($middleware_co);

//Supprimer musique de la blibliothèque
/**$app->get('/jukebox/{tokenJukebox}/lol', function(Slim\Http\Request $req,  Slim\Http\Response $res, $args) use ($app){
    $lc = new LibraryController();
    echo $lc->deleteTrackLibrary($args['tokenJukebox']);
});*/

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
    return $ac->disconnect($req, $res,$args);
});

$app->run();
