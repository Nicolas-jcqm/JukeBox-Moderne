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
     * @param $request
     * @param $reponse
     * @return string
     * TODO https://laravel.com/docs/5.4/eloquent-relationships#updating-many-to-many-relationships attaching
     */
    public function addTrackIntoLibrary($request, $response){

        $params = (array)json_decode($request->getBody());

         $jukebox= $this->jc->returnJukebox($params["tokenJukebox"]);

            if ($this->jc->jukeboxExist($jukebox->idJukebox)) {
                if ( $this->tc->trackExist($params["idTrack"])) {
                    if($this->trackIsInLibrary($jukebox->idJukebox,$params["idTrack"])) {
                        $musicInLibrary = new JukeboxLibrary;
                        $musicInLibrary->idJukebox = $jukebox->idJukebox;
                        $musicInLibrary->idTrack = $params["idTrack"];
                        $musicInLibrary->save();
                    }else return json_encode(array('error'=>'idTrack already in Library'));
                } else return json_encode(array('error'=>'idTrack unknown'));
            } else return json_encode(array('error'=>'idJukebox unknown'));

        return $response->withJson(array('success'=>'track insert into queue'))->withStatus(201);
    }

    public function trackIsInLibrary($j, $t){
        return JukeboxLibrary::where('idJukebox','=',$j)->where('idTrack','=',$t)->count() == 0;
    }


}