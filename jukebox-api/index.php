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
use Controllers\QueueController;
use conf\Eloquent;

Eloquent::init('src/conf/config.ini');

$app = new Slim\App([
    'settings' => [
        'displayErrorDetails' => true
    ]
]);

$app->add(function(Slim\Http\Request $request, Slim\Http\Response $response, callable $next){
	$response = $response->withHeader('Content-type', 'application/json; charset=utf-8');
	$response = $response->withHeader('Access-Control-Allow-Origin', '*');
	$response = $response->withHeader('Access-Control-Allow-Methods', 'OPTION, GET, POST, PUT, PATCH, DELETE');
	return $next($request, $response);
});

$app->get('/jukebox/{tokenJukebox}',function (Slim\Http\Request $req,  Slim\Http\Response $res, $args)  use ($app){
    echo "<pre>";
    $jc = new JukeboxController();
    echo $jc->returnJukeBox($args['tokenJukebox']);
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
    return $ac->disconnect($req, $res);
});


$app->run();
