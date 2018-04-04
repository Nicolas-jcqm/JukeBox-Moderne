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

    /**
     * Retourne le jukebox d'un administrateur donné
     * @param $administratorJukebox
     * @return mixed
     */
    public function returnJukeboxAdmin($administratorJukebox){
         $admin = Jukebox::where('administratorJukebox','=',$administratorJukebox)->get();
         if($admin == null) return json_encode(array('error'=>'No jukebox'));
         else return $admin;
    }

    /**
     * Retourne le jukebox lié au token donné en paramètre
     * @param $tokenJukeBox
     * @return mixed
     */
    public function returnJukebox($tokenJukeBox){
        return Jukebox::where('tokenJukebox','=',$tokenJukeBox)->first();
    }

    /**
     * Retourne la queue active à lire d'un jukebox à partir de son token
     * @param $tokenJukebox
     * @return mixed
     */
    public function returnQueues($tokenJukebox){
        $idJuk = $this->returnJukebox($tokenJukebox);
        if($idJuk == null) return json_encode(array('error'=>'tokenJukebox unknown'));
        $queue = $this->pc->returnActiveQueue($idJuk->idJukebox);
        if($queue == null) return json_encode(array('error'=>'no queue'));
        else return $queue;
    }

    public function returnTracks($tokenJukeBox){
        $idJuk = $this->returnJukebox($tokenJukeBox);
        if($idJuk == null) return json_encode(array('error'=>'Token Jukebox unknown'));
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

    /**
     * Retourne un boolean indiquant si un jukebox existe bien, à partir de son Id
     * @param $id
     * @return bool
     */
    public function jukeboxExist($id){
        $exists = Jukebox::where('idJukebox','=',$id)->get()->count();
        if($exists == 1) return true;
            else return false;
    }

    /**
     * Retourne un boolean indiquant si un jukebox existe bien, à partir de son token
     * @param $token
     * @return bool
     */
    public function jukeboxExistWithToken($token){
        $exists = Jukebox::where('tokenJukebox','=',$token)->get()->count();
        if($exists == 1) return true;
        else return false;
    }

    /**
     * Retourne le token d'un jukebox à partir de son Id
     * @param $id
     * @return string
     */
    public function returnJukeboxToken($id){
        if($this->jukeboxExist($id))
            return Jukebox::select('tokenJukebox')->where('idJukebox','=',$id)->first();
        else return json_encode(array('error'=>'idJukebox unknown'));
    }

    /**
     * Retourne l'id d'un jukebox à partir de son token
     * @param $id
     * @return string
     */
    public function returnJukeboxId($token){
        if($this->jukeboxExistWithToken($token))
            return Jukebox::select('idJukebox')->where('tokenJukebox','=',$token)->first();
        else return json_encode(array('error'=>'token unknown'));
    }

    /**
     * Test
     */
    public function testToken(){
        // create a storage object to hold refresh tokens
        $storage = new OAuth2\Storage\Pdo(array('dsn' => 'sqlite:refreshtokens.sqlite'));
        // create the grant type
        $grantType = new OAuth2\GrantType\RefreshToken($storage);
        // add the grant type to your OAuth server
        $server->addGrantType($grantType);
    }

}
