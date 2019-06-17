<?php
/**
 * Created by PhpStorm.
 * User: jamesskywalker
 * Date: 03/06/2019
 * Time: 23:31
 */
class loggedInUser {

    protected $id;
    protected $username;
    protected $lastLogin;
    protected $gamesStarted;
    protected $gamesFinished;
    protected $gamesPaused;
    protected $averageTime;
    protected $totalGuesses;
    protected $averageGuesses;
    protected $totalGameTime;
    protected $totalGames;
    protected $loginToken;
    public $games;

    private $userSql;

    public function __construct($id,$username) {
        $this->id = abs($id);
        $this->username = $username;
        $this->userSql = new usersSql();
    }

    public function changeUsername($username) {
        if($this->checkUsernameIsUnique($username)) {
            return $this->updateUsername($username);
        }
    }

    public function register($username,$password) {
        $register = new registerSql($username,$password);
        if($id = $register->registerUser()) {
            $this->username = $username;
            $this->id = $id;
        }
    }

    public function getDetails() {
        $user = new stdClass();
        $user->id = $this->id;
        $user->username = $this->username;
        $user->lastLogin = $this->lastLogin;
        $user->gamesStarted = $this->gamesStarted;
        $user->gamesFinished = $this->gamesFinished;
        return $user;
    }

    public function getUserStats() {
        if($this->setUserStats()) {
            $stats = new stdClass();
            $stats->gamesStarted = $this->gamesStarted ?? 0;
            $stats->gamesFinished = $this->gamesFinished ?? 0;
            $stats->gamesPaused = $this->gamesPaused ?? 0;
            $stats->totalGuesses = $this->totalGuesses ?? 0;
            $stats->averageGuesses = $this->averageGuesses ?? 0;
            $stats->totalTime = $this->totalGameTime ?? 0;
            $stats->averageTime = $this->averageTime ?? 0;
            $stats->totalGames = $this->totalGames ?? 0;
            return $stats;
        }
        return false;
    }

    public function getGamesHistory(bool $update = false) {
        if(!isset($this->games) || $update ) {
            $this->setUserGames();
        }
        return $this->games;
    }

    private function getLoginToken() {
       $this->loginToken = $_COOKIE['loginToken'] ?? null;
    }

    private function setUserStats() {
        if($stats = $this->userSql->getStatsForUser($this->id)){
            $this->gamesStarted = $stats->gamesStarted;
            $this->gamesFinished = $stats->gamesFinished;
            $this->gamesPaused = $stats->gamesPaused;
            $this->averageTime = $stats->averageTime;
            $this->totalGuesses = $stats->totalGuesses;
            $this->averageGuesses = $stats->averageGuesses;
            $this->totalGameTime = $stats->totalTime;
            $this->totalGames = $stats->totalGames;
            return true;
        }
        return false;


    }

    private function checkUsernameIsUnique($username){
        return true;
    }

    private function setUserGames() {
        $userGames = $this->userSql->getGameHistoryForUser($this->id);
        if(count($userGames) > 0) {
            $this->games = array_map(function($g){
                $game = new userGame($this->id,$g->gameId);
                $game->setGameFromResult($g);
                return $game;
            },$userGames);
        } return false;
    }




}