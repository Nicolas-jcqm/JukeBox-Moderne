<?php

/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 19/02/2018
 * Time: 13:23
 */

namespace Models;

use \Illuminate\Database\Eloquent\Model;

class Jukebox extends Model {

    protected $table = 'jukebox';
    protected $primaryKey = 'idJukebox';
    public $timestamps = false;

    public function queues(){
        return $this->hasMany("Models\Queue", 'idJukebox');
    }

    public function administrator(){
        return $this->hasOne('Models\Administrator', 'administratorJukebox');
    }

    public function tracks(){
        return $this->belongsToMany('\Models\Track', 'jukeboxlibrary', 'idJukebox', 'idTrack');
    }

}