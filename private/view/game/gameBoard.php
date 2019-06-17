<?php
/**
 * Created by PhpStorm.
 * User: jamesskywalker
 * Date: 05/06/2019
 * Time: 23:06
 */

function loadGameBoardView($tiles,$rows) {

    $content = '<div class="container">
                    <div  class="row boardRow">';
    $i = 1;
    foreach ($tiles as $key => $tile) {
        if($i > 1 && $i-1%$rows == 0) $content .='</div><div class="row boardRow">';
        $tile = $tile->get();
        if(!$tile->revealed) {
            $content.= '<div id="' . $tile->position . '" class="gameTile pull-left text-center">';
            $content .= '<h6 class="tileTitle">DIG JIM LAD!</h6>';
            $content .= '<div class="container gameBackground dig"></div>';
            $content .='<h6 class="tileFooter gold"></h6>';
        } else {
            $content.= '<div id="' . $tile->position . '" class="gameTile pull-left text-center revealed">';
            if($tile->prizeSquare) {
                $content .= '<h6 class="tileTitle gold">D\'arrgh Jim lad!</h6><div class="container gameBackground gold"></div>';
            } else {
                $content .= '<h6 class="tileTitle fail">D\'arrgh bad luck!</h6><div class="container gameBackground fail">You be just ' . $tile->squaresAway . ' square' . ($tile->squaresAway == 1 ? '' : 's') . ' away!</div>';
            }
        }

        $content .='</div>';
        $i++;
    }

    $content .= '</div>';
    return $content;
}