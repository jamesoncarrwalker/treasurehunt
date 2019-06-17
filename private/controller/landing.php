<?php

/**
 * Created by PhpStorm.
 * User: jamesskywalker
 * Date: 02/06/2019
 * Time: 21:10
 */
class landing  {
    /**
     * landing constructor.
     * basic page has  $page which needs body setting ($this->page->body = view();
     * optional css/js can be added to $this->page->head
     *
     *
     */
    public $version;
    public $page;
    private $main;
    public function __construct($call) {
        $this->main = new main();
        $this->page = new stdClass();
        $this->page->head = '';
        $this->page->body = '';
        $this->page->head .= '<script type="text/javascript" src="' . BASE . 'private/js/landing.js?' . DOC_VERSION . '"></script><script type="text/javascript">BASE = "' . BASE . '";</script>';
        if (isset($call) && method_exists($this, $call)) {
            $this->$call();
        } else $this->loadLandingPage();


    }

    public function loadLandingPage() {
        $this->page->body = $this->main->loadPageView('landing',[]);
        return $this->page;
    }

    public function register() {
        $user = new loggedInUser(null,null);
        $user->register($_POST['username'],$_POST['password']);
        if(isset($user->getDetails()->id)) {
            $this->login();
        } else return $this->loadLandingPage();
    }

    public function login() {
        $username = util::washingMachine($_POST['username']);
        $password = util::washingMachine($_POST['password']);
        $sli = isset($_POST['sli']) ? $_POST['sli'] == 'on' : false;
        $login = new login($username,$password,$sli);
        if($login->logInWeb()) {
            unset($password,$_POST['password']);
            header("location: " . BASE ."home/");
            exit();
        } else {
            unset($password,$_POST['password']);
            header("location: " . BASE);
            exit();
        }
    }
}