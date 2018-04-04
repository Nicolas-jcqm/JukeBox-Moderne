<?php
/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 20/02/2018
 * Time: 13:21
 */

namespace Controllers;

use Models\Queue;
use Models\QueueContent;

class QueueController
{

    private $tc;

    public function __construct()
    {
        $this->tc = new TrackController();
    }

    public function returnQueuesFromJukebox($idJuk)
    {
        return Queue::where('idJukebox', '=', $idJuk)->first();
    }

    /**
     * Retourne la playlist à lire d'un jukebox donné
     * @param $idJuk
     * @return mixed
     */
    public function returnActiveQueue($idJuk) {
        return Queue::where('idJukebox', '=', $idJuk)->where('isActivated', '=', '1')->first();
    }

    public function queueExist($idQueue)
    {
        return Queue::find($idQueue)->exists;
    }

}
