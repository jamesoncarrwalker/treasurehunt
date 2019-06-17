<?php
/**
 * Created by PhpStorm.
 * User: jamesskywalker
 * Date: 04/06/2019
 * Time: 20:21
 */
function loadNewGameFormView() {
    $content = '<div class="container">
                    <div class="panel panel-primary">
                        <div class="panel-heading">New game</div>
                        <div class="panel-body">
                        <form class="form-horizontal" method="post" action="' . BASE .'play/newgame/">
                          <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                              <button type="button" id="startRandomGame" class="btn btn-default">Random game</button>
                            </div>
                          </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="timedGame"> Against the clock
                                </label>
                              </div>
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="rows" class="col-sm-2 control-label">Rows</label>
                            <div class="col-sm-10">
                              <input name="rows" type="number" class="form-control" id="rows" placeholder="5">
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="cols" class="col-sm-2 control-label">Cols</label>
                            <div class="col-sm-10">
                              <input name="cols" type="number" class="form-control" id="cols" placeholder="5">
                            </div>
                          </div>

                          <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                              <button type="submit" id="createGame" class="btn btn-default">Create</button>
                            </div>
                          </div>
                        </form>
</div>

                    </div>
                </div>';
    return $content;
}