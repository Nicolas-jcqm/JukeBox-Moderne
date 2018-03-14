<?php
/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 14/03/2018
 * Time: 17:42
 */

namespace Models;

use \Illuminate\Database\Eloquent\Model;

class JukeboxLibrary extends Model
{

    protected $table = 'jukeboxlibrary';
    protected $primaryKey = ['idJukebox','idTrack'];
    public $timestamps = false;

}