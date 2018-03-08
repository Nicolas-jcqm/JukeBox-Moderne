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
	private $ac;
	private $ak;


    public function __construct(){
        $this->pc =  new PlaylistController();
		$this->ac = new ArtistController();
		$this->ak = new KindController();
    }
    
    public function returnAll(){
        return Jukebox::all();
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
        return $this->returnJsonTracks($this->pc->returnActivePlaylist($idJuk->idJukebox));
    }

    public function returnJsonTracks($listTracks){
        $res=array();
        foreach ($listTracks->tracks as $t) {
            array_push($res, array("Title"=>$t->titleTrack, "Duration"=>$t->durationTrack, "Description"=>$t->descriptionTrack, "Score"=>$t->scoreTrack, "Year"=>$t->yearTrack, "Picture"=>$t->pictureTrack, "Url"=>$t->urlTrack, "Artist"=>$this->ac->returnNameArtist($t->idArtist), "Kind"=>$this->ak->returnNameKind($t->idKind) ));
        }
        return json_encode($res);
    }

}
