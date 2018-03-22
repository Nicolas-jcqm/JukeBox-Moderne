<?php
/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 08/03/2018
 * Time: 15:36
 */

namespace Controllers;

use Models\Track;
use Models\JukeboxLibrary; 

class LibraryController
{
 	private $kc;
    private $ac;
    private $jc;
    private $tc;

    public function __construct(){ 
        $this->kc = new KindController();
        $this->ac = new ArtistController();
        $this->jc = new JukeboxController();
        $this->tc = new TrackController();
    }

    //retourne le json d'une liste de track
    public function returnJsonTracks($listTracks){
        $res=array();

        foreach ($listTracks as $t) {
            array_push($res, array("id"=>$t->idTrack, "Title"=>$t->titleTrack, "Duration"=>$t->durationTrack, "Description"=>$t->descriptionTrack, "Score"=>$t->scoreTrack, "Year"=>$t->yearTrack, "Picture"=>$t->pictureTrack, "Url"=>$t->urlTrack, "Artist"=>$this->ac->returnNameArtist($t->idArtist), "Kind"=>$this->kc->returnNameKind($t->idKind) ));
        }
        return json_encode($res);
    }

    public function returnLibraryTracks($tokenJukeBox){
		$listLibrary = [];
		$library = [];

		//recuperation jukebox avec le token
        $Juk = $this->jc->returnJukebox($tokenJukeBox);
		$idJuk = $Juk->idJukebox;

		//liste des idtracks de sa bibliothèque
		$jukeboxLibrary=  JukeboxLibrary::where('idJukebox','=',$idJuk)->get();
		foreach ($jukeboxLibrary as $jl) {
			array_push($listLibrary, $jl->idTrack);
		}
		//correspondance entre idTrack et la track
		foreach ($listLibrary as $idTrack) {
			if($this->tc->trackExist($idTrack)){
				array_push($library, Track::where('idTrack','=',$idTrack)->first());
			}
		}
		return  $this->returnJsonTracks($library);
    }
/**
    public function deleteTrackLibrary($tokenJukeBox){
    	$library = $this->returnLibraryTracks($tokenJukeBox);
    	$json = json_decode($library);
    	var_dump($json[1]);
    	foreach ($json as $track) {
    		
    			//var_dump($track->titleTrack);
    		
    	}

    }
    */

}