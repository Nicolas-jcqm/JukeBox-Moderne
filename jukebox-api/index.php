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
use Controllers\QueueController;
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

$app->post('/jukebox/library/track',function (Slim\Http\Request $req,  Slim\Http\Response $res, $args)  use ($app){
    $jlc = new JukeboxLibraryController();
    return $jlc->addTrackIntoLibrary($req, $res);
});

$app->post('/jukebox/queue/track',function (Slim\Http\Request $req,  Slim\Http\Response $res, $args)  use ($app) {
    $qcc = new QueueContentController();
    return $qcc->addTrackIntoQueue($req, $res);
});

$middleware_co = function (Slim\Http\Request $request, Slim\Http\Response $response, $next) {
    if(isset($_GET['token'])){
        $tokenReq = $_GET['token'];
    }
    
    if(isset($_SESSION['token'])){
           if($_SESSION['token'] == $tokenReq){
            return $next($request, $response);
        }else {
            return $response->withJson(['Wrong token' => 'can t connect'], 403);
        }
      }else {
          return $response->withJson(['No token' => 'can t connect'], 401);
      }  
};

$app->get('/jukeboxs/{administratorJukebox}',function (Slim\Http\Request $req,  Slim\Http\Response $res, $args)  use ($app){
    $jc = new JukeboxController();
    echo $jc->returnJukeboxAdmin($args['administratorJukebox']);
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
//Afficher le catalogue
$app->get('/trackCatalog', function(Slim\Http\Request $req,  Slim\Http\Response $res, $args) use ($app){
    $jc = new TrackController();
    echo $jc->returnTrackCatalog();
});

//Afficher la bibliothèque d'un jukebox
$app->get('/jukebox/{tokenJukebox}/library/tracks', function(Slim\Http\Request $req,  Slim\Http\Response $res, $args) use ($app){
    $lc = new LibraryController();
    echo $lc->returnLibraryTracks($args['tokenJukebox']);
});
//Supprimer musique de la blibliothèque
/**$app->get('/jukebox/{tokenJukebox}/lol', function(Slim\Http\Request $req,  Slim\Http\Response $res, $args) use ($app){
    $lc = new LibraryController();
    echo $lc->deleteTrackLibrary($args['tokenJukebox']);
});
/*
$app->post('/playlist/tracks',function() use ($app){
    if(isset($_POST['idPlaylist']) && isset($_POST['idTrack']) ){
        $pc = new PlaylistController();
        echo $pc->addTrackIntoPlaylist($_POST['idPlaylist'], $_POST['idTrack']);
    }else{
        echo json_encode(array('error'=>'data missing'));
    }
})->name('addTracksPlaylist');

$app->post('/jukebox/:tokenJukebox/playlist/tracks',function($tokenJukeBox) use ($app){
    $jc = new JukeboxController();
    $listTracks = $jc->returnTracks($tokenJukeBox);
    foreach ($listTracks->tracks as $t) { echo $t; }
})->name('tracksPlaylist');*/

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
