<?php
/**
 * Created by PhpStorm.
 * User: jamesskywalker
 * Date: 02/06/2019
 * Time: 19:34
 */
class letsGetItOn {
    protected $page;
    protected $load;

    function __construct() {
        //set up your routing pathways
    }

    public function loadPage($page) {
        echo $page->head;
        echo '<body><div class="container">';
        echo $page->body;
        echo '</div></body>';

    }

    public function loadApiResponsePage($response){
        echo $response;
    }

    public function checkLogin() {

        //write your login checks
    }
}