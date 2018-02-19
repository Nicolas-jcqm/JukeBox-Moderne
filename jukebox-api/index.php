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
use giftbox\Controleur\Controleur;
use giftbox\Controleur\ControleurCatalogue;
use conf\Eloquent;

\Slim\Slim::registerAutoloader();

Eloquent::init('src/conf/config.ini');

$app = new \Slim\slim();

// Accueil Controleur
$app->get('/accueil',function() use ($app){
    $control = new Controleur($app);
    $control->afficherAccueil();
})->name('accueil');

$app->run();