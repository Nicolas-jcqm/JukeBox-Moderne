<?php
/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 19/02/2018
 * Time: 15:43
 */

namespace Models;

use \Illuminate\Database\Eloquent\Model;


class Kind extends Model{

    protected $table = 'kind';
    protected $primaryKey = 'idKind';
    public $timestamps = false;

}