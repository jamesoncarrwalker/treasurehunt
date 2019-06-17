<?php

/**
 * Created by PhpStorm.
 * User: jamesskywalker
 * Date: 04/06/2019
 * Time: 19:15
 */
class game {

    protected $id;
    protected $rows;
    protected $cols;
    protected $timed;
    protected $treasurePosition;

    public function __construct(int $rows,int $cols,bool $timed) {
        $this->rows = $rows;
        $this->cols = $cols;
        $this->timed = $timed;
        $this->tiles = [];
    }

    public function create() {
        $this->chooseWinningPosition();
        $this->registerGame();

    }

    public function setWinningPosition(string $position) {
        $this->treasurePosition = $position;
    }

    public function get() {
        $game = new stdClass();
        $game->id = $this->id;
        $game->rows = $this->rows;
        $game->cols = $this->cols;
        $game->timed = $this->timed;
        $game->treasurePosition = $this->treasurePosition;

        return $game;
    }

    private function registerGame() {
        $games = new gamesSql();
        return ($this->id = $games->registerGame($this->timed,$this->rows,$this->cols,$this->treasurePosition));
    }

    private function chooseWinningPosition() {
        $col = rand(1,$this->cols);
        $row = rand(1,$this->rows);
        $this->setWinningPosition($position = "C" . $col . ":R" . $row);
    }


}