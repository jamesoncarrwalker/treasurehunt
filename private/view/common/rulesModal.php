<?php
/**
 * Created by PhpStorm.
 * User: jamesskywalker
 * Date: 08/06/2019
 * Time: 18:35
 */

function loadRulesModalView() {
    return  '
    <div class="modal fade" id="rulesModal" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">How to play</h4>
          </div>
          <div class="modal-body">
            <p>D\'arrgh me hearty treasure hunting couldn\'t be simpler:</p>
            <ol>
                <li>Click a tile</li>
                    <ul><li>This will start the timer (if you are playing against the clock), you can start the timer manually if you don\'t want to jump straight in</li>
                        <li>Clicking a tile or pausing the game will also save your progress</li>
                    </ul>
                <li>Work out how close you are - remember the game can count diagonally to find the fastest route!</li>
            </ol>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Save changes</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
';
}