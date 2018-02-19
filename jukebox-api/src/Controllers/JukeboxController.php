<?php
/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 19/02/2018
 * Time: 15:54
 */

namespace Controllers;

use Models\Jukebox;


class JukeboxController {

    public function __construct(){

    }

    public function affichh(){
        $lp = Jukebox::select("idJukeBox")->first();
        return $lp;
    }

}