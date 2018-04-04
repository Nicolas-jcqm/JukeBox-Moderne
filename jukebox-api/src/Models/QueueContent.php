<?php

/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 20/02/2018
 * Time: 00:09
 */

namespace Models;

use \Illuminate\Database\Eloquent\Model;

class QueueContent extends Model{

    protected $table = 'queuecontent';
    protected $primaryKey = 'idQueueContent';
    public $timestamps = false;

}