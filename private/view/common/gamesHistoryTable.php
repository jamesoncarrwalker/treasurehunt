<?php
/**
 * Created by PhpStorm.
 * User: jamesskywalker
 * Date: 04/06/2019
 * Time: 19:42
 */
function loadGamesHistoryTableView($gamesHistory) {
    $content = '<div class="container">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            Games history
                        </div>
                        <div class="table-responsive">
                              <table class="table table-hover ">
                                  <tr>
                                      <th>Timed game?</th>
                                      <th>Started</th>
                                      <th>Time spent</th>
                                      <th>Finished</th>
                                  </tr>';
                                    foreach($gamesHistory as $g) {
                                        $g = $g->get();
                                        $rowClass = $g->started < 1 ? 'danger' : ($g->finished >= $g->started ? 'success' : 'bg-warning');
                                        $content.=
                                        '<tr onclick=\'window.location="' . BASE . 'play/loadGame/?id=' . $g->gameId . '"\' class="historyRow ' . $rowClass . ' " id="' . $g->id . '" >' .
                                            '<td>' . (isset($g->timed) && $g->timed ? 'Yes' : "-") . '</td>' .
                                            '<td>' . (isset($g->started) && $g->started > 0 ? date('d/m/Y H:i', $g->started) : " - ") . '</td>' .
                                            '<td>' . (isset($g->timeTaken) && $g->timeTaken > 0 ? util::displaySecondsForHumans($g->timeTaken) : ' - ') . '</td>' .
                                            '<td>' . (isset($g->finished) && $g->finished > 0 ? date('d/m/Y H:i', $g->finished) : " - " ). '</td>
                                        </tr>';
                                    }
                        $content.= '
                            </table>
                        </div>
                    </div>
                </div>';
    return $content;
}