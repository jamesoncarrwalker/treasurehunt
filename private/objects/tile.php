<?php

/**
 * Created by PhpStorm.
 * User: jamesskywalker
 * Date: 05/06/2019
 * Time: 13:55
 */
class tile {

    protected $position;
    protected $revealed;
    protected $prizeSquare;
    protected $squaresAway;

    public function __construct(string $position,bool $revealed, bool $prizeSquare) {
        $this->position = $position;
        $this->revealed = $revealed;
        $this->prizeSquare = $prizeSquare;
    }

    public function get(){
        $tile = new stdClass();
        $tile->position = $this->position;
        $tile->revealed = $this->revealed;
        $tile->prizeSquare = $this->prizeSquare;
        $tile->squaresAway = $this->squaresAway;
        return $tile;
    }

    public function setRevealed(bool $status) {
        $this->revealed = $status;
    }

    public function isPrizeSquare() {
        return $this->prizeSquare;
    }

    public function getDistanceFromTile(string $goalPosition) {
        if(!isset($this->squaresAway)) $this->setDistanceFromTile($goalPosition);
        $squaresAway = $this->squaresAway;
        return $squaresAway;
    }

    public function setDistanceFromTile(string $goalPosition) {
        $goalCoOrds = explode(':',$goalPosition);
        $tileCoOrds = explode(':',$this->position);
        $squaresAway = 0;
        $goalCol = (int) filter_var($goalCoOrds[0], FILTER_SANITIZE_NUMBER_INT);
        $goalRow = (int) filter_var($goalCoOrds[1], FILTER_SANITIZE_NUMBER_INT);
        $tileCol = (int) filter_var($tileCoOrds[0], FILTER_SANITIZE_NUMBER_INT);
        $tileRow =  (int) filter_var($tileCoOrds[1], FILTER_SANITIZE_NUMBER_INT);

        while(!($goalCol == $tileCol && $goalRow == $tileRow)) {

            //do we just need to move up or down
            if($goalCol == $tileCol){
                if($goalRow > $tileRow) $squaresAway+= $goalRow - $tileRow;
                else if($goalRow < $tileRow) $squaresAway+= $tileRow - $goalRow;
                break;//we are already in the col, so just a simple sum to get the total
                //do we just need to move left or right
            } else if($goalRow == $tileRow){
                if($goalCol > $tileCol) $squaresAway+= $goalCol - $tileCol;
                else if($goalCol < $tileCol) $squaresAway+= $tileCol - $goalCol;
                break;//we are already in the row, so just a simple sum to get the total
                //otherwise we need to get moving, so try to move left diagonally
            } else if($tileCol > $goalCol) {
                $tileCol--;
                if ($tileRow > $goalRow) $tileRow--; //minus 1 (move up the table, down the rows)
                if ($tileRow < $goalRow) $tileRow++; //plus 1 (move down the table, up the row)
                //or move right diagonally
            } else if($tileCol < $goalCol) {
                $tileCol++;
                if($tileRow > $goalRow) $tileRow--; //minus 1 (move up the table, down the rows)
                if($tileRow < $goalRow) $tileRow++;
            }

            $squaresAway++;//be sure to add on a square for total
        }
        $this->squaresAway = $squaresAway;
    }

    public function restoreSquaresAway(int $squaresAway) {
        $this->squaresAway = $squaresAway;
    }

}