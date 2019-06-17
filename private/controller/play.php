<?php

/**
 * Created by PhpStorm.
 * User: jamesskywalker
 * Date: 05/06/2019
 * Time: 13:42
 */
class play extends loggedInPage {
    public function __construct($call) {
        parent::__construct();

        if (isset($call) && method_exists($this, $call)) {
            $this->$call();
        } else header('location:'. BASE);
    }


    public function newGame() {
        $rows = abs(util::washingMachine($_POST['rows'] ?? 0));
        $cols = abs(util::washingMachine($_POST['cols'] ?? 0));
        if($rows == 0) $rows = rand(1,5);
        if($cols == 0) $cols = rand(1,5);
        $this->setupGame($rows,$cols,(isset($_POST['timedGame']) && $_POST['timedGame'] == 'on'));
        return $this->page;
    }

    public function random() {
        $rows = rand(1,10);
        $cols = rand(1,10);
        $this->setupGame($rows,$cols,true);
        return $this->page;
    }

    public function loadGame() {
        $userGame = new userGame($_SESSION['userId'],(int)$_GET['id']);
        $userGame->loadGame();
        $gameDetails = $userGame->get();
        $this->page->head .= '<script type="text/javascript" src="' . BASE . 'private/js/game.js?' . DOC_VERSION . '"></script>';
        $this->page->head .= '<script type="text/javascript">
                                                currentGameId = ' . $gameDetails->gameId . '
                                                numCols = ' . $gameDetails->detail->cols . ';
                                                timeTaken = ' . abs($gameDetails->timeTaken) . ';
                                                gameFinished = ' . ($gameDetails->finished > 0 ? 'true' : 'false') . ';
                                  </script>';
        $this->subViews->progressBar = $this->main->getSubView('game', 'progressBar', [$userGame->getGameStatus(), $gameDetails->detail->timed]);
        $this->subViews->gameBoard = $this->main->getSubView('game', 'gameBoard', [$userGame->tiles, $gameDetails->detail->rows]);
        $this->subViews->rulesModal = $this->main->getSubView('common', 'rulesModal', []);
        $this->page->body = $this->main->loadPageView('game', (object)['views' => $this->subViews]);
        $this->page->body .= util::runCredits();

    }

    private function setupGame(int $rows, int $cols,bool $timed) {
        $game = new game($rows,$cols,$timed);
        $game->create();
        $gameDetails = $game->get();

        if(isset($gameDetails->id)) {
            $userGame = new userGame($this->loggedInUser->getDetails()->id, $gameDetails->id);
            $userGame->setGameDetails($gameDetails);
            $userGame->createTiles();
            $userGame->register();
            $this->page->head .= '<script type="text/javascript" src="' . BASE . 'private/js/game.js?' . DOC_VERSION . '"></script>';
            $this->page->head .= '<script type="text/javascript">
                                                currentGameId = ' . $gameDetails->id . '
                                                numCols = ' . $cols . ';
                                                timeTaken = ' . abs($userGame->get()->timeTaken) . ';
                                                gameFinished = ' . ($userGame->get()->finished > 0 ? 'true' : 'false') . ';
                                  </script>';
            $this->subViews->progressBar = $this->main->getSubView('game', 'progressBar', [$userGame->getGameStatus(), $gameDetails->timed]);
            $this->subViews->gameBoard = $this->main->getSubView('game', 'gameBoard', [$userGame->tiles, $gameDetails->rows]);
            $this->subViews->rulesModal = $this->main->getSubView('common', 'rulesModal', []);
            $this->page->body = $this->main->loadPageView('game', (object)['views' => $this->subViews]);

            $this->page->body .= util::runCredits();
        }
    }

}