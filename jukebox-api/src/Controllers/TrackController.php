<?php
/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 21/02/2018
 * Time: 16:08
 */

namespace Controllers;

use Models\Track;


class TrackController
{

    public function __construct(){ }

    public function trackExist($idTrack){
        return Track::where('idTrack','=',$idTrack)->get()->count() == 1;
    }

}