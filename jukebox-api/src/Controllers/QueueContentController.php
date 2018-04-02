<?php
/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 22/03/2018
 * Time: 10:26
 */

namespace Controllers;


use Models\QueueContent;

class QueueContentController
{

    private $jc;
    private $tc;
    private $qc;

    public function __construct(){
        $this->jc = new JukeboxController();
        $this->tc = new TrackController();
        $this->qc = new QueueController();
    }

    /**
     * @param $request
     * @param $reponse
     * @return string
     * TODO https://laravel.com/docs/5.4/eloquent-relationships#updating-many-to-many-relationships
     */
    public function addTrackIntoQueue($request, $reponse) {
        $params = (array)json_decode($request->getBody());
        $queue = $this->qc->returnQueuesFromJukebox($params["idJukebox"]);

        // D'un jukebox, numero de la queue , numero de la musique, statut de la personnne
        if ($this->qc->queueExist($queue->idQueue)) {

            if (isset($params['idTrack']) && $this->tc->trackExist($params['idTrack'])) {
                if (isset($params['userTrack'])) {
                    $newTrackIntoQueue = new QueueContent();
                    $newTrackIntoQueue->idQueue = $queue->idQueue;
                    $newTrackIntoQueue->idTrack = $params["idTrack"];
                    $newTrackIntoQueue->positionTrack = $this->returnLengthQueue($queue->idQueue);
                    $newTrackIntoQueue->userTrack = $params["userTrack"];
                    $newTrackIntoQueue->save();
                    return json_encode(array('success'=>'track insert into queue'));
                } else {
                    return json_encode(array('error'=>'user unknown'));
                }
            } else {
            return json_encode(array('error'=>'track unknown'));
            }
        } else{
         return json_encode(array('error'=>'queue unknown'));
         }
    }


    public function returnLengthQueue($idQueue){
        return QueueContent::where('idQueue','=',$idQueue)->count()+1;
    }



}