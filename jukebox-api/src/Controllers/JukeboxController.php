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
        return $this->returnJsonTracks($this->pc->returnActivePlaylist($idJuk->idJukebox));
    }

    public function returnJsonTracks($listTracks){
        $res=array();
        foreach ($listTracks->tracks as $t) {
            array_push($res, array("Title"=>$t->titleTrack, "Duration"=>$t->durationTrack, "Description"=>$t->descriptionTrack, "Score"=>$t->scoreTrack, "Year"=>$t->yearTrack, "Picture"=>$t->pictureTrack, "Url"=>$t->urlTrack, "Artist"=>"n", "Kind"=>"n"));
        }
        return json_encode($res);
    }

    //creation d'un jukebox
    public function addJukeBox($request, $response){
        
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
            /*if (strpos($contentType, 'application/json') !== false) {
                $newResponse = $response->withJson(["erreur"=>"1"], 400);    
            }else{
                $newResponse = $response->withJson()->withStatus(500);    

            }
            return $newResponse;*/
        }
    }
}
