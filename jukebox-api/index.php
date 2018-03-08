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
use Controllers\PlaylistController;
use conf\Eloquent;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

\Slim\Slim::registerAutoloader();

Eloquent::init('src/conf/config.ini');

$app = new \Slim\slim();

$app->get('/test',function() use ($app){
    echo "Welcome to api home page";
})->name('home');

$app->get('/jukebox/:tokenJukebox',function($tokenJukeBox) use ($app){
    $jc = new JukeboxController();
    echo $jc->returnJukeBox($tokenJukeBox);
})->name('jukebox');

$app->get('/jukebox/:tokenJukebox/playlists',function($tokenJukeBox) use ($app){
    $jc = new JukeboxController();
    echo $jc->returnPlaylists($tokenJukeBox);
})->name('jukeboxPlaylists');

$app->get('/jukebox/:tokenJukebox/playlist/tracks',function($tokenJukeBox) use ($app){
    $jc = new JukeboxController();
    echo $jc->returnTracks($tokenJukeBox);
})->name('tracksPlaylist');

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
})->name('tracksPlaylist');

$app->post('/admin/signin',function() use ($app){
    $ac = new AdminController();
    return $ac->Signin($app->request, $app->response);
})->name('admin_signin');

$app->post('/admin/signup',function() use ($app){
    $ac = new AdminController();
    return $ac->Signup($app->request, $app->response);
})->name('admin_signup');

$app->get('/admin/logout',function() use ($app){
    $ac = new AdminController();
    return $ac->disconnect();
})->name('admin_disconnect');


$app->run();