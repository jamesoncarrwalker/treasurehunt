<?php

/**
 * Created by PhpStorm.
 * User: jamesskywalker
 * Date: 02/06/2019
 * Time: 20:33
 */
class loggedInPage {

    protected $main;
    public $page;
    public $subViews;
    protected $loggedInUser;

    function __construct() {
        $this->loggedInUser = new loggedInUser($_SESSION['userId']??null,$_SESSION['username']??null);
        $this->main = new main();
        $this->subViews = new stdClass();
        $this->page = new stdClass();
        $this->page->body = '';
        $this->page->head = '';
    }
}