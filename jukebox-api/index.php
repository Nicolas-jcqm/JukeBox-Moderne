<?php
/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 19/02/2018
 * Time: 13:29
 */

session_start();
include_once 'vendor/autoload.php';

use Illuminate\Database\Capsule\Manager;
use Controllers\JukeboxController;
use conf\Eloquent;

\Slim\Slim::registerAutoloader();

Eloquent::init('src/conf/config.ini');

$app = new \Slim\slim();

// Retourne la liste des musiques pour le Jukebox 1
$app->get('/jukebox/1',function() use ($app){
    $control = new JukeboxController();
    echo $control->affichh();
})->name('jukebox');

$app->run();