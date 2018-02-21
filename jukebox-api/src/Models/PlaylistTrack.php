<?php

/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 20/02/2018
 * Time: 00:09
 */

namespace Models;

use \Illuminate\Database\Eloquent\Model;

class PlaylistTrack extends Model{

    protected $table = 'playlist_track';
    protected $primaryKey = ['idPlaylist','idTrack'];
    public $timestamps = false;

}