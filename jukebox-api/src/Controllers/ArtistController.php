<?php
/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 21/02/2018
 * Time: 18:21
 */

namespace Controllers;


use Models\Artist;

class ArtistController
{

	public function __construct(){ }

	public function returnNameArtist($idArtist){
        $res = Artist::select('nameArtist')->where('idArtist','like',$idArtist)->first();
        return $res->nameArtist;
    }

}