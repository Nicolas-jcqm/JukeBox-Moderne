<?php
/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 22/03/2018
 * Time: 10:26
 */

namespace Controllers;


use Models\Jukebox;
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
     * Ajoute une musique de la bibliotheque du jukebox dans la queue active
     * @param $request
     * @param $reponse
     * @return string
     */
    public function addTrackIntoQueue($request, $reponse) {
        $params = (array)json_decode($request->getBody());
        if(isset($params['tokenJukebox'])) {
            $jukebox = $this->jc->returnJukebox($params["tokenJukebox"]);
            if ($jukebox != null) {
                $queue = $this->qc->returnActiveQueue($jukebox->idJukebox);
                if ($queue != null) {
                    if (isset($params['idTrack']) && $this->tc->trackExist($params['idTrack'])) {
                        if (isset($params['userTrack'])) {
                            if($this->trackIsAlreadyInQueue($queue->idQueue,$params['idTrack'])) {
                                $newTrackIntoQueue = new QueueContent();
                                $newTrackIntoQueue->idQueue = $queue->idQueue;
                                $newTrackIntoQueue->idTrack = $params["idTrack"];
                                $newTrackIntoQueue->positionTrack = $this->returnLengthQueue($queue->idQueue);
                                $newTrackIntoQueue->userTrack = $params["userTrack"];
                                $newTrackIntoQueue->score = 0;
                                $newTrackIntoQueue->status = "not read";
                                $newTrackIntoQueue->save();
                                return json_encode(array('success' => 'track insert into queue'));
                            }else return json_encode(array('error' => 'track is already in queue'));
                        } else return json_encode(array('error' => 'user unknown'));
                    } else return json_encode(array('error' => 'track unknown'));
                } else return json_encode(array('error' => 'no queue'));
            } else return json_encode(array('error' => 'Jukebox unknown'));
        }else return json_encode(array('error' => 'Token Jukebox unknown'));
    }

    /**
     * Retourne la derniere place pour une musique à insérer d'une queue donné
     * @param $idQueue
     * @return int
     */
    public function returnLengthQueue($idQueue){
        return QueueContent::where('idQueue','=',$idQueue)->count()+1;
    }

    /**
     * Retourne un boolean indiquant si la musique est déja présente dans la queue donnée
     * @param $idQueue
     * @param $idTrack
     * @return bool
     */
    public function trackIsAlreadyInQueue($idQueue, $idTrack){
        return QueueContent::where('idQueue','=',$idQueue)->where('idTrack','=',$idTrack)->count() == 0;
    }

    public function vote($request, $response) {
        $params = (array)json_decode($request->getBody());

        if (isset($params["tokenJukebox"]) && $this->jc->jukeboxExistWithToken($params["tokenJukebox"])) {
            $idQueue = $this->qc->returnActiveQueue($this->jc->returnJukeboxId($params["tokenJukebox"])->idJukebox);
            if (isset($params['idTrack']) && $this->tc->trackExist($params['idTrack'])) {
                if (isset($params['score'])) {
                    $trackVote = QueueContent::where('idQueue','=',$idQueue->idQueue)->where('idTrack','=',$params["idTrack"])->first();
                    if($params['score'] == 1) $trackVote->score = $trackVote->score +1;
                    $trackVote->save();
                    return $this->returnNotRead($idQueue);
                } else return json_encode(array('error'=>'score unknown 2'));
            } else return json_encode(array('error'=>'track unknown'));
        } else return json_encode(array('error'=>'queue unknown'));
    }

    public function refreshStatusTrack($request, $response){
        $params = (array)json_decode($request->getBody());
        if (isset($params["tokenJukebox"]) && $this->jc->jukeboxExistWithToken($params["tokenJukebox"])) {
            if (isset($params['idTrack']) && $this->tc->trackExist($params['idTrack'])) {
                $queue = $this->qc->returnActiveQueue($this->jc->returnJukeboxId($params["tokenJukebox"])->idJukebox);
                $track = QueueContent::where('idQueue','=', $queue->idQueue)->where('idTrack','=',$params['idTrack'])->first();
                $track->status = "read";
                $track->save();
                $this->restartQueue($queue->idQueue);
                return $this->returnNotRead($queue);
            }
        }
    }

    public function returnNotRead($queue){
        $liste = QueueContent::select('idTrack')->where('idQueue','=',$queue->idQueue)->orderBy('status','ASC')->orderBy('score','DESC')->orderBy('positionTrack','ASC')->get();
        return $this->tc->returnJsonTracks2($liste);
    }

    public function restartQueue($idQueue){
        $resRead = QueueContent::where('status','like','not read')->where('idQueue','=',$idQueue)->count();
        if($resRead == 0) QueueContent::where('idQueue','=',$idQueue)->update(['status' => 'not read']);
        $this->restartScore($idQueue);
    }

    public function restartScore($idQueue){
        QueueContent::where('idQueue','=',$idQueue)->update(['score' => '0']);
    }

}
