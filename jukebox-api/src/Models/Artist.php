<?php

/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 19/02/2018
 * Time: 15:43
 */

namespace Models;

use \Illuminate\Database\Eloquent\Model;


class Artist extends Model{

    protected $table = 'artist';
    protected $primaryKey = 'idArtist';
    public $timestamps = false;

    public function tracks(){
        return $this->hasMany("Models\Track", 'idArtist');
    }

}