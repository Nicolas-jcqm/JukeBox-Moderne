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
    private $kc;
    private $ac;

    public function __construct(){ 
        $this->kc = new KindController();
        $this->ac = new ArtistController();
    }

    //retourne le json d'une liste de track
    public function returnJsonTracks($listTracks){
        $res=array();
        foreach ($listTracks as $t) {
            array_push($res, array("idTrack"=>$t->idTrack,"Title"=>$t->titleTrack, "Duration"=>$t->durationTrack, "Description"=>$t->descriptionTrack, "Score"=>$t->scoreTrack, "Year"=>$t->yearTrack, "Picture"=>$t->pictureTrack, "Url"=>$t->urlTrack, "Artist"=>$this->ac->returnNameArtist($t->idArtist), "Kind"=>$this->kc->returnNameKind($t->idKind) ));
        }
        return json_encode($res);
    }

    public function returnJsonTracks2($listidTracks){
        $res=array();
        foreach ($listidTracks as $tr) {
            $t = Track::where('idTrack','=',$tr->idTrack)->first();
           array_push($res, array("idTrack"=>$t->idTrack,"Title"=>$t->titleTrack, "Duration"=>$t->durationTrack, "Description"=>$t->descriptionTrack, "Score"=>$t->scoreTrack, "Year"=>$t->yearTrack, "Picture"=>$t->pictureTrack, "Url"=>$t->urlTrack, "Artist"=>$this->ac->returnNameArtist($t->idArtist), "Kind"=>$this->kc->returnNameKind($t->idKind) ));
        }
        return json_encode($res);
    }

    //retourne le catalogue en Json
	public function returnTrackCatalog(){
        $listTracks = Track::all();
	    return  $this->returnJsonTracks($listTracks);
	 }

    public function trackExist($idTrack){
        return Track::where('idTrack','=',$idTrack)->get()->count() == 1;
    }

   

}