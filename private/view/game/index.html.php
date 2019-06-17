<?php
/**
 * Created by PhpStorm.
 * User: jamesskywalker
 * Date: 05/06/2019
 * Time: 13:41
 */

function loadGamePage($params) {
    $content = '<div class="container">
                    <div class="jumbotron">
                        ' . $params->views->progressBar . '

                        ' . $params->views->gameBoard . '

                        ' . $params->views->rulesModal . '

                    </div>
                </div>';

    return $content;
}