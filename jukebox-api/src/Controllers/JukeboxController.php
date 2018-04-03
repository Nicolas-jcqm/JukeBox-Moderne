<?php

/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 19/02/2018
 * Time: 15:54
 */

namespace Controllers;

use Models\Jukebox;
use Models\JukeboxLibrary;

class JukeboxController {

    private $pc;
    private $ac;
    private $ak;


    public function __construct(){
        $this->pc =  new QueueController();
        $this->ac = new ArtistController();
        $this->ak = new KindController();
    }
    
    public function returnAll(){
        return Jukebox::all();
    }

    public function returnJukeboxAdmin($administratorJukebox){
         return Jukebox::where('administratorJukebox','=',$administratorJukebox)->get();
    }

    public function returnJukebox($tokenJukeBox){
        return Jukebox::where('tokenJukebox','=',$tokenJukeBox)->first();
    }

    public function returnQueues($tokenJukebox){
        $idJuk = $this->returnJukebox($tokenJukebox);
        return $this->pc->returnQueuesFromJukebox($idJuk->idJukebox);
    }

    public function returnTracks($tokenJukeBox){
        $idJuk = $this->returnJukebox($tokenJukeBox);
        echo ($this->pc->returnActiveQueue($idJuk->idJukebox));
        return $this->returnJsonTracks($this->pc->returnActiveQueue($idJuk->idJukebox));

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
        $erreurArray=[];
        $params = (array)json_decode($request->getBody());
           
        if(isset($request)){
            
           // $descriptionJukebox =$params['descriptionJukebox'];
            
            //vérification du nom attribué au jukebox
            if(empty($params['nameJukebox'])){
                $erreurNom ="Merci d'entrer un nom";
               array_push($erreurArray,$erreurNom);

            }else{

                if($params['nameJukebox'] != filter_var($params['nameJukebox'], FILTER_SANITIZE_STRING,FILTER_FLAG_STRIP_HIGH)){
                    $erreurFiltre ="Merci d'entrer un nom valide";
                    array_push($erreurArray,$erreurFiltre);
                }
                $nameJukebox = $params['nameJukebox'];
            }
            //vérification du pseudo de l'admin attribué au jukebox
            if(empty( $params['administratorJukebox'])){
                $erreurName ="Merci d'entrer un pseudo admin";
                array_push($erreurArray,$erreurName);

            }else{

                if(!filter_var($params['administratorJukebox'], FILTER_SANITIZE_STRING,FILTER_FLAG_STRIP_HIGH)){
                    $erreurNameFiltre ="Merci d'entrer un pseudo admin valide";
                    array_push($erreurArray,$erreurNameFiltre);   
                }
                $administratorJukebox = $params['administratorJukebox'];
            }
            //vérification de la description attribué au jukebox
            if(empty($params['descriptionJukebox'])){
                $erreurNom ="Merci d'entrer une description";
               array_push($erreurArray,$erreurNom);

            }else{

                if($params['descriptionJukebox'] != filter_var($params['descriptionJukebox'], FILTER_SANITIZE_STRING,FILTER_FLAG_STRIP_HIGH)){
                    $erreurFiltre ="Merci d'entrer une description valide";
                    array_push($erreurArray,$erreurFiltre);
                }
                $descriptionJukebox = $params['descriptionJukebox'];
            }

            //si aucune erreur
            if (sizeof($erreurArray) ===0 ){
               

                $jukebox = new Jukebox();
                $jukebox->nameJukebox = $nameJukebox;
                $jukebox->administratorJukebox = $administratorJukebox;
                $jukebox->tokenJukebox = bin2hex(openssl_random_pseudo_bytes(16));;
                $jukebox->description = $descriptionJukebox;
                $jukebox->save();

                //return code 200
                return $response->withJson($jukebox)->withStatus(201);

            }

            else{
                return $response->withJson(['Erreur' => 'Jukebox pas creer','Type' => 'Unprocessable entity', 'Erreurs' => $erreurArray ], 422);
            }

    
        }else{
            return $response->withJson(['Erreur' => 'interne au réseau','Type' => 'Unknow', 'Erreurs' => $erreurArray ], 500);
        }
    }

    public function jukeboxExist($id){
        $exists = Jukebox::where('idJukebox','=',$id)->get()->count();
        if($exists == 1) return true;
            else return false;
    }

    public function returnJukeboxToken($id){
        if(Jukebox::find($id)->exists)
            return Jukebox::select('tokenJukebox')->where('idJukebox','=',$id)->first();
        else
            return json_encode(array('error'=>'idJukebox unknown'));
    }

}
