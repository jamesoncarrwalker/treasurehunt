<?php
/**
 * Created by PhpStorm.
 * User: jamesskywalker
 * Date: 05/06/2019
 * Time: 13:47
 */
function loadProgressBarView($userGame,$timed) {



    $content = '<div class="container">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                              <div class="panel-heading">Time: <span id="timer">' . ($timed ? $userGame->timeTaken : 'NA') . '</span></div>
                            </div>

                              <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                <div class="panel-heading">Started: <span id="started">' . (isset($userGame->started) && $userGame->started > 0  ? date('d/m/Y H:i',$userGame->started) : 'NA') . '</span></div>
                            </div>

                             <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                  <div class="panel-heading">Finished: <span id="finished">' . (isset($userGame->finished) && $userGame->finished > 0 ? date('d/m/Y H:i',$userGame->started) : 'NA') . '</span></div>
                            </div>

                             <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                  <div class="panel-heading">Guesses: <span id="guessesTotal">' . (isset($userGame->guesses)  ? $userGame->guesses : 'NA') . '</span></div> '
                                   . ($timed ? '<button id="toggleTimerButton" class="btn btn-default">Start</button>' : '') . '
                            <button  class="btn btn-default" data-toggle="modal" data-target="#rulesModal">Rules</button>
                            </div>
                        </div>
                </div>
            </div>';

    return $content;
}