<?php

/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 19/02/2018
 * Time: 15:54
 */

namespace Controllers;

use Models\Jukebox;

class JukeboxController{

    private $qc;
	private $ac;
	private $ak;

    public function __construct(){
        $this->qc =  new QueueController();
		$this->ac = new ArtistController();
		$this->ak = new KindController();
    }
    
    public function returnAll(){
        return Jukebox::all();
    }

    public function returnJukebox($tokenJukebox){
        return Jukebox::where('tokenJukebox','like',$tokenJukebox)->first();
    }

    public function returnQueues($tokenJukebox){
        $idJuk = $this->returnJukeBox($tokenJukebox);
        return $this->qc->returnQueuesFromJukebox($idJuk->idJukebox);
    }

    public function returnTracks($tokenJukebox){
        $idJuk = $this->returnJukeBox($tokenJukebox);
        return $this->returnJsonTracks($this->qc->returnActiveQueue($idJuk->idJukebox));
    }

    public function returnJsonTracks($listTracks){
        $res=array();
        foreach ($listTracks->tracks as $t) {
            array_push($res, array("Title"=>$t->titleTrack, "Duration"=>$t->durationTrack, "Description"=>$t->descriptionTrack, "Score"=>$t->scoreTrack, "Year"=>$t->yearTrack, "Picture"=>$t->pictureTrack, "Url"=>$t->urlTrack, "Artist"=>$this->ac->returnNameArtist($t->idArtist), "Kind"=>$this->ak->returnNameKind($t->idKind) ));
        }
        return json_encode($res);
    }

    //creation d'un jukebox
    public function addJukeBox($request, $response){
        echo 'lol';
        $params = (array)json_decode($request->getBody());
        try{
            $jukebox = new Jukebox();
            $jukebox->nameJukebox = $params['nameJukebox'];
            $jukebox->tokenJukeBox = $params['tokenJukebox'];
            $jukebox->administratorJukebox = $params['administratorJukebox'];
            $jukebox->save();
        
            return $response->withJson($jukebox)->withStatus(201);
        }catch (\Illuminate\Database\QueryException $e){
            $contentType = $request->getContentType();
            if (strpos($contentType, 'application/json') !== false) {
                $newResponse = $response->withJson(["erreur"=>"1"], 400);    
            }else{
                $newResponse = $response->withJson(["erreur"=>"2"])->withStatus(500);    

            }

            return $newResponse;
        }
    }
}
