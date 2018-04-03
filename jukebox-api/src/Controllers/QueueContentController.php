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

    public function vote($request, $response) {
        $params = (array)json_decode($request->getBody());

        if (isset($params["idQueue"]) && $this->qc->queueExist($params["idQueue"])) {
            if (isset($params['idTrack']) && $this->tc->trackExist($params['idTrack'])) {
                if (isset($params['score'])) {
                    $trackVote = QueueContent::where('idQueue','=',$params["idQueue"])->where('idTrack','=',$params["idTrack"])->first();
                    if($params['score'] == 1) $trackVote->score = $trackVote->score +1;
                    $trackVote->save();
                    return json_encode(array('success'=>'score update'));
                } else return json_encode(array('error'=>'score unknown 2'));
            } else return json_encode(array('error'=>'track unknown'));
        } else return json_encode(array('error'=>'queue unknown'));
    }

    public function refreshStatusTrack($request, $response){
        $params = (array)json_decode($request->getBody());
        if (isset($params["idJukebox"]) && $this->jc->jukeboxExist($params["idJukebox"])) {
            if (isset($params['idTrack']) && $this->tc->trackExist($params['idTrack'])) {
                $queue = $this->qc->returnActiveQueue($params["idJukebox"]);
                $track = QueueContent::where('idQueue','=', $queue->idQueue)->where('idTrack','=',$params['idTrack'])->first();
                $track->status = "read";
                $track->save();
                return json_encode(array('success'=>$this->returnNotRead($queue)));
            }
        }
    }

    public function returnNotRead($queue){
        $liste = QueueContent::select('idTrack')->where('idQueue','=',$queue->idQueue)->where('status','like','not read')->orderBy('score','DESC')->orderBy('positionTrack','ASC')->get();
        return $this->tc->returnJsonTracks2($liste);
    }

}
