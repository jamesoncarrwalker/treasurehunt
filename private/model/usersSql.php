<?php

/**
 * Created by PhpStorm.
 * User: jamesskywalker
 * Date: 03/06/2019
 * Time: 23:48
 */
class usersSql extends only {

    private $conn;

    public function __construct() {
        //create a db connection
    }

    public function checkUsernameIsUnique($username) {
        $username = util::washingMachine($username);

        $q = $this->conn->prepare("SELECT COUNT(username) FROM users WHERE username = :username");
        $q->bindValue(":username",$username,PDO::PARAM_STR);
        $q->execute();
        return abs($q->fetchColumn());
    }

    public function getStatsForUser($userId) {
        $q = $this->conn->prepare(" SELECT
                                    SUM(IF(started > 0,1,0)) AS gamesStarted,
                                    SUM(IF(finished > 0,1,0)) AS gamesFinished,
                                    SUM(IF(started > 0 AND finished = 0,1,0)) AS gamesPaused,

                                    SUM(guesses) AS totalGuesses,
                                    SUM(timeTaken) AS totalTime,
                                    SUM(guesses) / COUNT(id) AS averageGuesses,
                                    SUM(timeTaken) / COUNT(id) AS averageTime,
                                    COUNT(id) AS totalGames

                                    FROM userProgress
                                    WHERE userId = :userId

                                    ");
        $q->bindValue(':userId',$userId,PDO::PARAM_INT);
        $q->execute();
        return $q->fetch();
    }

    public function getGameHistoryForUser($userId) {
        $q = $this->conn->prepare("SELECT up.*,games.timed,`rows`,cols,treasurePosition FROM
                                   userProgress up
                                   INNER JOIN games ON (games.id = up.gameId)
                                   WHERE userId = :userId");
        $q->bindValue(':userId',$userId,PDO::PARAM_INT);
        $q->execute();
        return $q->fetchAll();
    }



}