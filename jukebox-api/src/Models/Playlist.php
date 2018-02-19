<?php
/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 19/02/2018
 * Time: 15:43
 */

namespace Models;

use \Illuminate\Database\Eloquent\Model;


class Playlist extends Model{

    protected $table = 'playlist';
    protected $primaryKey = 'idPlaylist';
    public $timestamps = false;

}