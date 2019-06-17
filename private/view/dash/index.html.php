<?php
/**
 * Created by PhpStorm.
 * User: jamesskywalker
 * Date: 04/06/2019
 * Time: 13:23
 */

function loadDashPage($params) {

    $content = '<div class="container">
                    <div class="jumbotron">
                        ' . $params->views->stats . '
                    </div>

                    <div class="jumbotron">
                        <div class="container">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                ' . $params->views->gamesHistoryTable . '
                            </div>

                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                ' . $params->views->newGame . '
                            </div>
                        </div>
                    </div>
                </div>';

return $content;
}