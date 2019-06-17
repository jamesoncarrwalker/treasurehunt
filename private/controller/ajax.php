<?php

/**
 * Created by PhpStorm.
 * User: jamesskywalker
 * Date: 02/06/2019
 * Time: 20:32
 */
class ajax {

    private $params;
    public $return;

    public function __construct()
    {
        //check we have a call and assign it
        if ( (isset($_GET['ajaxCall']) || isset($_POST['ajaxCall']))) {
            $call = ($_GET['ajaxCall'] != '') ? $_GET['ajaxCall'] : $_POST['ajaxCall'];
            if(method_exists($this,$call)) {
                //then get the data and call the function now we are happy we are ok to do so
                $this->params = json_decode($this->params = ($_GET['data'] != '') ? $_GET['data'] : $_POST['data']);
                $this->$call();
            } else $this->return = (object)['SET_ERROR'=>AJAX_INCORRECT_CALL];
        } else {
            $this->return = (object)['SET_ERROR'=>AJAX_INCORRECT_CALL];
        }
    }

    public static function ajaxPublicCalls() {
        return ['checkUsernameIsUnique'];
    }

    public function getResponse() {
        return $this->return;
    }

    private function checkUsernameIsUnique() {
        if(util::hasRequiredData((array)$this->params,['username'])) {
            $sql = new usersSql();

            if($sql->checkUsernameIsUnique($this->params->username) < 1) {
                $this->return = (object)["usernameAvailable" => true];
            } else $this->return = (object)["usernameAvailable" => false];

        } else  $this->return = (object)['SET_ERROR'=>"Please enter a username"];
    }

    private function selectTile() {
        if(util::hasRequiredData((array)$this->params,['position','currentGame'])) {
            $game = new userGame($_SESSION['userId'],$this->params->currentGame,null);
            if($game->restoreGameTiles()){
                if($tile = $game->getTile(urldecode($this->params->position))) {
                    $tile->setRevealed(true);
                    if($tile->isPrizeSquare()) $game->setFinishTime();
                    $game->replaceTile($tile);
                    if(isset($this->params->timeTaken)) $game->updateTimeTaken($this->params->timeTaken);
                    if($game->saveUpdate()){
                        $gameDetail = $game->get();
                        $this->return = (object) ['tile' =>$tile->get(),
                            'started' => date('d/m H:i',$gameDetail->started),
                            'finished' => $gameDetail->finished > 0 ? date('d/m H:i',$gameDetail->finished) : null];
                    } else $this->return = (object)['SET_ERROR'=>"Avast, something went wrong!"];

                } else $this->return = (object)['SET_ERROR'=>"Could not find that tile"];
            } else $this->return = (object)['SET_ERROR'=>"Could not find the tiles for your game"];
        } else  $this->return = (object)['SET_ERROR'=>"Could not find that tile"];
    }

    private function updateGameTime() {
        if(isset($this->params->gameId)) {
            $gameSql = new gamesSql();
            $gameSql->updateTimeTaken($this->params->gameId, $this->params->timeTaken);

        }
        $this->return = (object)[];
    }
}