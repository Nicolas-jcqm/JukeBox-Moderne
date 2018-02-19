<?php
/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 19/02/2018
 * Time: 13:27
 */

namespace Models;

use \Illuminate\Database\Eloquent\Model;


class Track extends Model {

    protected $table = 'track';
    protected $primaryKey = 'idTrack';
    public $timestamps = false;

}