<?php
/**
 * Created by PhpStorm.
 * User: jamesskywalker
 * Date: 04/06/2019
 * Time: 16:52
 */

function loadGamesStatsView($gameStats) {
    $content = '
                <div class="container">
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 statTile align-center">

                        <h3 class="text-center">Progress</h3>
                        <ul class="list-unstyled text-center">
                            <li>Started : ' . $gameStats->gamesStarted . '</li>
                            <li>Paused : ' . $gameStats->gamesPaused . '</li>
                            <li>Finished : ' . $gameStats->gamesFinished . '</li>
                        </ul>

                    </div>

                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 statTile">
                     <h3 class="text-center">Guesses</h3>
                        <ul class="list-unstyled text-center">
                            <li>Total guesses : ' . $gameStats->totalGuesses . '</li>
                            <li>Guesses per game (avg) : ' . round($gameStats->averageGuesses,2) . '</li>
                            <li>Time per game (avg) : ' . round($gameStats->averageTime,2) . '</li>
                        </ul>
                    </div>

                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 statTile">
                        <h3 class="text-center">Overall</h3>
                        <ul class="list-unstyled text-center">
                            <li>Created : ' . $gameStats->totalGames . '</li>
                            <li>Time spent (sec): ' . ($gameStats->totalGames > 0 ? $gameStats->totalTime : 0)  . '</li>
                            <li>Incomplete : ' . ($gameStats->gamesStarted - $gameStats->gamesFinished) . '</li>
                        </ul>

                    </div>
                </div>
                ';

    return $content;
}