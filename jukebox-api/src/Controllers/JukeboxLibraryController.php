<?php

/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 20/03/2018
 * Time: 11:24
 */

namespace Controllers;

use Models\JukeboxLibrary;

class JukeboxLibraryController {

    private $tc;
    private $jc;

    public function __construct(){
        $this->tc = new TrackController();
        $this->jc = new JukeboxController();
    }

    /**
     * Ajoute une musique du catalogue dans la bibliotheque du jukebox
     * @param $request
     * @param $response
     * @return string
     */
    public function addTrackIntoLibrary($request, $response){
        $params = (array)json_decode($request->getBody());
         $jukebox = $this->jc->returnJukebox($params["tokenJukebox"]);
            if ($jukebox != null) {
                if ( $this->tc->trackExist($params["idTrack"])) {
                    if($this->trackIsInLibrary($jukebox->idJukebox,$params["idTrack"])) {
                        $musicInLibrary = new JukeboxLibrary;
                        $musicInLibrary->idJukebox = $jukebox->idJukebox;
                        $musicInLibrary->idTrack = $params["idTrack"];
                        $musicInLibrary->save();
                    }else return json_encode(array('error'=>'idTrack already in Library'));
                } else return json_encode(array('error'=>'idTrack unknown'));
            } else return json_encode(array('error'=>'Token Jukebox unknown'));
        return $response->withJson(array('success'=>'track insert into queue'))->withStatus(201);
    }

    /**
     * Retourne un boolean indiquant si une musique est bien absente de la bibliotheque du jukebox
     * @param $j
     *  id du jukebox
     * @param $t
     *  id de la musique
     * @return bool
     */
    public function trackIsInLibrary($j, $t){
        return JukeboxLibrary::where('idJukebox','=',$j)->where('idTrack','=',$t)->count() == 0;
    }


}