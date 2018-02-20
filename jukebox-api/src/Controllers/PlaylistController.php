<?php
/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 20/02/2018
 * Time: 13:21
 */

namespace Controllers;


use Models\Playlist;

class PlaylistController
{

    public function __construct(){ }

    public function returnPlaylistsFromJukebox($idJuk){
        return Playlist::where('idJukebox','=',$idJuk)->get();
    }

    /**
     * TODO
     * Gerer le cas où aucune playlist n'est active
     */
    public function returnActivePlaylist($idJuk){
        $activePl = Playlist::where('idJukebox','=',$idJuk)->where('isActivated','=','1')->first();
        return $activePl;
    }

}