<?php

/**
 * Created by PhpStorm.
 * User: jamesskywalker
 * Date: 02/06/2019
 * Time: 20:38
 */
class home extends loggedInPage {

    public function __construct($call) {
        parent::__construct();

        if (isset($call) && method_exists($this, $call)) {
            $this->$call();
        } else $this->loadDash();
    }

    public function loadDash() {
        $this->subViews->stats = $this->main->getSubView('common','gamesStats',[$this->loggedInUser->getUserStats()]);
        $this->subViews->gamesHistoryTable = $this->main->getSubView('common','gamesHistoryTable',[$this->loggedInUser->getGamesHistory() ?? []]);
        $this->subViews->newGame = $this->main->getSubView('common','newGameForm',[]);

        $this->page->head = '<script type="text/javascript">
                                $(document).ready(function(){
                                    $("#startRandomGame").on("click",function(){
                                                window.location.replace("' . BASE . 'play/random/");
                                    });
                                });
                            </script>';

        $this->page->body = $this->main->loadPageView('dash',(object)['views' => $this->subViews]);
        return $this->page;
    }

    public function logout() {
        $logout = new login(null,null,null);
        $logout->logoutUserBy($_SESSION['userId'],'userId');
        session_destroy();
        if(isset($_COOKIE['sli'])) unset($_COOKIE['sli']);
        setcookie("sli", '', time() - 3600);
        header("location: " . BASE);
        exit();
    }
}