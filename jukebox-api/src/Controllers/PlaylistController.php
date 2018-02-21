<?php
/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 20/02/2018
 * Time: 13:21
 */

namespace Controllers;


use Models\Playlist;
use Models\PlaylistTrack;

class PlaylistController
{

    private $tc;

    public function __construct(){
        $this->tc = new TrackController();
    }

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

    public function addTrackIntoPlaylist($idPlaylist, $idTrack){
        $insertPlaylistTrack = new PlaylistTrack();
        if($this->playlistExist($idPlaylist) ){
            if ($this->tc->trackExist($idTrack)){
                $insertPlaylistTrack->idPlaylist = $idPlaylist;
                $insertPlaylistTrack->idTrack = $idTrack+"";
                $insertPlaylistTrack->positionTrack = 0;
                $insertPlaylistTrack->save();
                return json_encode(array('success'=>'track insert into playlist'));
            }else
                return json_encode(array('error'=>'idTrack unknown'));
        }else
            return json_encode(array('error'=>'idPlaylist unknown'));
    }

    public function playlistExist($idPlaylist){
        return Playlist::where('idPlaylist','=',$idPlaylist)->get()->count() == 1;
    }

    public function returnLengthPlaylist($idPlaylist){
        return playlistTrack::where('idPlaylist','=',$idPlaylist)->get()->count()+1;
    }



}

/**
 * Ajouter une musique dans une playlist
 * Ajouter une musique tout court
 */