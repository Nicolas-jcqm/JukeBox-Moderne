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
        return Queue::where('idJukebox', '=', $idJuk)->get();
    }

    /**
     * TODO
     * Gerer le cas où aucune playlist n'est active
     */
    public function returnActiveQueue($idJuk)
    {
        $activePl = Queue::where('idJukebox', '=', $idJuk)->where('isActivated', '=', '1')->first();
        return $activePl;
    }

    public function queueExist($idQueue)
    {
        return Queue::where('idQueue', '=', $idQueue)->get()->count() == 1;
    }

}