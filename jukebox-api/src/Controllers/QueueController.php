<?php
/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 20/02/2018
 * Time: 13:21
 */

namespace Controllers;

use Models\Queue;
use Models\QueueContent;

class QueueController {

    private $tc;

    public function __construct(){
        $this->tc = new TrackController();
    }

    public function returnQueuesFromJukebox($idJuk){
        return Queue::where('idJukebox','=',$idJuk)->get();
    }

    /**
     * TODO
     * Gerer le cas où aucune playlist n'est active
     */
    public function returnActiveQueue($idJuk){
        $activePl = Queue::where('idJukebox','=',$idJuk)->where('isActivated','=','1')->first();
        return $activePl;
    }

    public function addTrackIntoPlaylist($idJukeboxLibrary, $idTrack){
        $insertJukeboxLibraryTrack = new QueueContent();
        if($this->jukeboxLibraryExist($idJukeboxLibrary) ){
            if ($this->tc->trackExist($idTrack)){
                $insertJukeboxLibraryTrack->idPlaylist = $idJukeboxLibrary;
                $insertJukeboxLibraryTrack->idTrack = $idTrack;
                $insertJukeboxLibraryTrack->positionTrack = 0;
                $insertJukeboxLibraryTrack->save();
                return json_encode(array('success'=>'track insert into playlist'));
            }else
                return json_encode(array('error'=>'idTrack unknown'));
        }else
            return json_encode(array('error'=>'idPlaylist unknown'));
    }

    public function queueExist($idQueue){
        return Queue::where('idQueue','=',$idQueue)->get()->count() == 1;
    }

    public function returnLengthQueue($idQueue){
        return QueueContent::where('idQueue','=',$idQueue)->get()->count()+1;
    }

}

/**
 * Ajouter une musique dans une playlist
 * Ajouter une musique tout court
 */