<?php

/**
 * Created by PhpStorm.
 * User: jamesskywalker
 * Date: 04/06/2019
 * Time: 17:46
 */
class gamesSql extends only {

    private $conn;

    public function __construct() {
        //create a pdo connection
    }

    public function registerGame(bool $timed,int $rows,int $cols,string $treasurePos) {
        $q = $this->conn->prepare("INSERT INTO games (timed,rows,cols,treasurePosition)
                                   VALUES (:timed,:rows,:cols,:treasurePosition)");
        $q->bindValue(':timed',$timed,PDO::PARAM_BOOL);
        $q->bindValue(':rows',$rows,PDO::PARAM_INT);
        $q->bindValue(':cols',$cols,PDO::PARAM_INT);
        $q->bindValue(':treasurePosition',$treasurePos,PDO::PARAM_STR);
        $q->execute();
        return $q->rowCount() > 0 ? $this->conn->lastInsertId() : false;
    }

    public function addUserGame(int $gameId,int $userId,string $tiles) {
        $q = $this->conn->prepare("INSERT INTO userProgress (gameId,userId,tiles) VALUES (:gameId,:userId,:tiles)");
        $q->bindValue(':gameId',$gameId,PDO::PARAM_INT);
        $q->bindValue(':userId',$userId,PDO::PARAM_INT);
        $q->bindValue(':tiles',$tiles,PDO::PARAM_STR);
        $q->execute();
        return $q->rowCount() > 0 ? $this->conn->lastInsertId() : false;
    }

    public function getUserGameWithDetails(int $gameId,int $userId) {
        $q = $this->conn->prepare("SELECT g.timed,g.rows,g.cols,g.treasurePosition,up.*
                                   FROM games g
                                   INNER JOIN userProgress up ON g.id = up.gameId
                                   WHERE up.userId = :userId
                                   AND g.id = :gameId");
        $q->bindValue(':userId',$userId,PDO::PARAM_INT);
        $q->bindValue(':gameId',$gameId,PDO::PARAM_INT);
        $q->execute();
        return $q->fetch();

    }

    public function getTiles(int $userId,int $gameId) {
        $q = $this->conn->prepare("SELECT tiles FROM userProgress WHERE gameId = :gameId AND userId = :userId");
        $q->bindValue(':gameId',$gameId,PDO::PARAM_INT);
        $q->bindValue(':userId',$userId,PDO::PARAM_INT);
        $q->execute();
        return $q->fetchColumn();
    }

    public function saveGame(int $gameId,int $userId,$jsonTiles,int $timeTaken,int $finshed) {
        $q = $this->conn->prepare("UPDATE userProgress SET
                                   tiles = :tiles,
                                   started = IF(started = 0,:time,started),
                                   finished = :finished,
                                   timeTaken = :timeTaken,
                                   guesses = guesses + 1
                                   WHERE gameId = :gameId
                                   AND userId = :userId");
        $q->bindValue(':tiles',$jsonTiles,PDO::PARAM_STR);
        $q->bindValue(':time',time(),PDO::PARAM_INT);
        $q->bindValue(':timeTaken',$timeTaken,PDO::PARAM_INT);
        $q->bindValue(':gameId',$gameId,PDO::PARAM_INT);
        $q->bindValue(':userId',$userId,PDO::PARAM_INT);
        $q->bindValue(':finished',$finshed,PDO::PARAM_INT);
        $q->execute();
        return $q->rowCount() > 0;

    }

    public function updateTimeTaken(int $gameId,int $timeTaken) {
        $q = $this->conn->prepare("UPDATE userProgress SET timeTaken = :timeTaken
                                   WHERE userId = :userId
                                   AND gameId = :gameId");
        $q->bindValue(':timeTaken',$timeTaken,PDO::PARAM_INT);
        $q->bindValue(':userId',$_SESSION['userId'],PDO::PARAM_INT);
        $q->bindParam(':gameId',$gameId,PDO::PARAM_INT);
        $q->execute();
        return $q->rowCount() > 0;
    }

}