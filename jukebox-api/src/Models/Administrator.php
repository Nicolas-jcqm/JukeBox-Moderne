<?php
/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 19/02/2018
 * Time: 15:43
 */

namespace Models;

use \Illuminate\Database\Eloquent\Model;


class Administrator extends Model {

    protected $table = 'administrator';
    protected $primaryKey = 'mail';
    public $timestamps = false;

}