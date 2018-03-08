<?php
/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 08/03/2018
 * Time: 15:36
 */

namespace Controllers;

use Models\Kind;

class KindController
{

    public function returnNameKind($idKind){
        $res = Kind::select('nameKind')->where('idKind','like',$idKind)->first();
        return $res->nameKind;
    }

}