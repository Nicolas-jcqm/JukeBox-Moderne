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

    //retourne le json d'une liste de track
    public function returnJsonTracks($listTracks){
        $res=array();
        foreach ($listTracks->tracks as $t) {
            array_push($res, array("Title"=>$t->titleTrack, "Duration"=>$t->durationTrack, "Description"=>$t->descriptionTrack, "Score"=>$t->scoreTrack, "Year"=>$t->yearTrack, "Picture"=>$t->pictureTrack, "Url"=>$t->urlTrack, "Artist"=>$this->ac->returnNameArtist($t->idArtist), "Kind"=>$this->ak->returnNameKind($t->idKind) ));
        }
        return json_encode($res);
    }
    //retourne le catalogue en Json
	public function returnTrackCatalog(){
	    return  returnJsonTracks(Track::all());
	 }

    public function trackExist($idTrack){
        return Track::where('idTrack','=',$idTrack)->get()->count() == 1;
    }

   

}