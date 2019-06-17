/**
 * Created by jamesskywalker on 06/06/2019.
 */

var currentGameId;
var timeTaken = 0;
var numCols;
var timerIsRunning = false;
var interval;
var gameFinished = false;
$(document).ready(function() {
    $('.gameTile').on('click', function () {
        if($('#toggleTimerButton').length) {
            if(!timerIsRunning) startTimer();
        }
        selectTile($(this));
    });
    var length =  $('.gameTile').width($('.boardRow').first().width()/numCols) - numCols*2;
    $('.gameTile').width(length).height(length);



    if(gameFinished) $('#toggleTimerButton').remove();
    else $('#toggleTimerButton').on('click',function(){
                if(!timerIsRunning) startTimer();
                else pauseTimer();
            });
});

$( window ).resize(function() {
    var length =  $('.gameTile').width($('.boardRow').first().width()/numCols) - numCols*2;
    $('.gameTile').width(length).height(length);
});


function startTimer() {
    if(!gameFinished) {
        interval = setInterval(function () {
            timeTaken++;
            $('#timer').text(timeTaken.toString());
            if (timeTaken % 30 == 0) saveGameTime();
        }, 1000);
        timerIsRunning = true;
        $('#toggleTimerButton').text('Pause');
    }
}

function pauseTimer() {
    clearInterval(interval);
    timerIsRunning = false;
    saveGameTime();
    $('#toggleTimerButton').text('Start');
}

function selectTile(el) {
    if($(el).hasClass('revealed,checking,winner')) return;
    $(el).addClass('checking');
    var json = JSON.stringify({currentGame:currentGameId,position:$(el).attr('id'),timeTaken:timeTaken});
    if(!gameFinished)ajaxRequest('GET','selectTile','updateSelectedTile',json);
}

function updateSelectedTile(response) {
    response = JSON.parse(response);
    if(response.hasOwnProperty("SET_ERROR")) {
        pauseTimer();
        alert(response.SET_ERROR);
        return;
    }
    if(response.tile.squaresAway === 0) {
        selectedWinner(response);
        return
    }

    $('#started').text(response.started);
    var tile =  $('#' + $.escapeSelector(response.tile.position));
    $(tile).addClass('revealed').removeClass('checking');
    $(tile).find('.gameBackground').removeClass('dig').addClass('fail').text('You be just ' + response.tile.squaresAway + ' square' + (response.tile.squaresAway == 1 ? '' : 's') + ' away!');
    $(tile).find('.tileTitle').addClass('fail').text('D\'arrgh bad luck!');



    var guesses = $('#guessesTotal').text();
    if(guesses == "NA") $('#guessesTotal').text('1');
    else {
        var guessesTotal = parseInt(guesses);
        guessesTotal++;
        $('#guessesTotal').text('' + guessesTotal );
    }

}

function selectedWinner(winningResponse) {
    gameFinished = true;
    if($('#toggleTimerButton').length) {
        if(timerIsRunning) pauseTimer();
    }
    var winningTile = winningResponse.tile;
    $('#finished').text(winningResponse.finished);
    var tile =  $('#' + $.escapeSelector(winningTile.position));
    $(tile).addClass('winner').removeClass('checking');
    $(tile).find('.gameBackground').removeClass('dig').addClass('gold');
    $(tile).find('.tileTitle').addClass('gold').text('D\'arrgh Jim Lad!');
    $('#toggleTimerButton').off('click').remove();
    showMessage();

}

function saveGameTime(){
    var json = JSON.stringify({timeTaken:timeTaken,gameId:currentGameId});
    ajaxRequest('GET','updateGameTime','gameSaved',json);

}

function showMessage() {
    setTimeout(alert('Shiver me timbers ye found the gold!'),2000);
}