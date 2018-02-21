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

    private $pc;


    public function __construct(){
        $this->pc =  new PlaylistController();
    }

    public function returnJukeBox($tokenJukeBox){
        return Jukebox::where('tokenJukebox','like',$tokenJukeBox)->first();
    }

    public function returnPlaylists($tokenJukebox){
        $idJuk = $this->returnJukeBox($tokenJukebox);
        return $this->pc->returnPlaylistsFromJukebox($idJuk->idJukebox);
    }

    public function returnTracks($tokenJukeBox){
        $idJuk = $this->returnJukeBox($tokenJukeBox);
        return $this->pc->returnActivePlaylist($idJuk->idJukebox);
    }

}
