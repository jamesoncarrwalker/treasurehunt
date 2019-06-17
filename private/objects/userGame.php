<?php

/**
 * Created by PhpStorm.
 * User: jamesskywalker
 * Date: 04/06/2019
 * Time: 19:32
 */
class userGame {

    protected $id;
    protected $userId;
    protected $gameId;
    protected $timeTaken;
    protected $started;
    protected $finished;
    protected $guesses;
    protected $gameDetail;
    private $gamesSql;
    public $tiles;


    public function __construct($userId,$gameId) {
        $this->gameId = $gameId;
        $this->userId = $userId;

    }

    public function setGameDetails($game) {
        $this->gameDetail = $game;
    }

    public function createTiles() {
        $this->makeTiles($this->gameDetail->treasurePosition,$this->gameDetail->rows,$this->gameDetail->cols);
    }

    public function register() {
        return $this->addGame();
    }

    public function setGameFromResult($details) {
        $this->restoreGame($details);
    }

    public function get() {
        $game = new stdClass();
        $game->id = $this->id;
        $game->gameId = $this->gameId;
        $game->userId = $this->userId;
        $game->timeTaken = $this->timeTaken;
        $game->started = $this->started;
        $game->finished = $this->finished;
        $game->guesses = $this->guesses;
        $game->detail = $this->gameDetail;
        return $game;
    }

    public function getGameStatus() {
        $usergame = new stdClass();
        $usergame->id = $this->id;
        $usergame->userId = $this->userId;
        $usergame->gameId = $this->gameId;
        $usergame->timeTaken = $this->timeTaken;
        $usergame->started = $this->started;
        $usergame->finished = $this->finished;
        $usergame->guesses = $this->guesses;
        return $usergame;

    }

    public function restoreGameTiles() {
        return $this->getGameTiles();
    }

    public function setIsTimedGame(bool $isTimed) {
        $this->timed = $isTimed;
    }

    public function getTile(String $position) {
        if($tile = $this->tiles[$position]) return $tile;
        return false;
    }

    public function replaceTile(tile $tile) {
        return $this->tileReplaced($tile);
    }

    public function loadGame() {
        $this->getUserGame();
    }

    public function updateTimeTaken(int $seconds) {
        $this->timeTaken = $seconds;
    }

    public function setFinishTime() {
        $this->finished = time();
    }

    public function saveUpdate() {
        return ($this->saveGameProgress() && $this->getUserGame());
    }

    private function addGame() {
        if(!isset($this->tiles)) return false;
        if(!isset($this->gamesSql)) $this->gamesSql = new gamesSql();
        return $this->id = $this->gamesSql->addUserGame($this->gameId,$this->userId,addslashes(json_encode(array_filter(array_map(function($t){
            return $t->get();
        },array_values($this->tiles))))));
    }

    private function saveGameProgress() {
        if(!isset($this->gameId,$this->userId,$this->tiles)) return false;
        if(!isset($this->gamesSql)) $this->gamesSql = new gamesSql();//don't open more connections that you need
        return $this->gamesSql->saveGame($this->gameId,$this->userId,addslashes(json_encode(array_filter(array_map(function($t){
            return $t->get();
        },array_values($this->tiles))))),abs($this->timeTaken),abs($this->finished));
    }

    private function getUserGame() {
        if (!isset($this->gamesSql)) $this->gamesSql = new gamesSql();
        $details = $this->gamesSql->getUserGameWithDetails($this->gameId, $this->userId);
        $this->restoreGame($details);
        return true;

    }

    private function restoreGame($details) {
        $game = new game($details->rows, $details->cols, abs($details->timed) > 0);
        $game->setWinningPosition($details->treasurePosition);
        $this->restoreTilesFromJson($details->tiles);
        $this->gameId = $details->gameId;
        $this->id = $details->id;
        $this->timeTaken = $details->timeTaken;
        $this->started = $details->started;
        $this->finished = $details->finished;
        $this->guesses = $details->guesses;
        $this->gameDetail = $game->get();
    }

    private function makeTiles(String $treasurePosition,int $rows, int $cols) {
        $x = 1;
        while($x <= $rows) {
            $n = 1;
            while($n <= $cols) {
                $position = "C" . $n . ":R" . $x;
                $tile = new tile($position,false,($position == $treasurePosition));
                $tile->setDistanceFromTile($treasurePosition);
                $this->tiles[$position] = $tile;
                $n++;
            }
            $x++;
        }
    }

    private function getGameTiles() {
        if(!isset($this->gamesSql)) $this->gamesSql = new gamesSql();
        if($jsonTiles = $this->gamesSql->getTiles($this->userId,$this->gameId)) {
            $this->restoreTilesFromJson($jsonTiles);
            return true;
        } else return false;
    }

    private function restoreTilesFromJson($jsonTiles) {

        foreach (json_decode(stripslashes($jsonTiles)) as $tile) {
            $squaresAway = $tile->squaresAway;
            $tile = new tile($tile->position, $tile->revealed, $tile->position == $tile->prizeSquare);
            $tile->restoreSquaresAway($squaresAway);
            $tileDetails = $tile->get();
            $this->tiles[$tileDetails->position] = $tile;
        }
    }

    private function tileReplaced(tile $tile) {
        $position = $tile->get()->position;
        if(!in_array($position,$this->tiles)) return false;
        $this->tiles[$position] = $tile;
    }
}