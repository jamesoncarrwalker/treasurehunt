<?php

/**
 * Created by PhpStorm.
 * User: jamesskywalker
 * Date: 02/06/2019
 * Time: 20:01
 */
class allthosewhowander extends loggedInPage {

    public function __construct($call) {
        parent::__construct();
        $this->page->body = $this->main->loadPageView('lost',[]);
        return $this->page;
    }
}