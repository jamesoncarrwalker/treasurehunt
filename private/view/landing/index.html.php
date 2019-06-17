<?php
/**
 * Created by PhpStorm.
 * User: jamesskywalker
 * Date: 03/06/2019
 * Time: 20:09
 */
function loadLandingPage($params) {
     $content = '<div class="container col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="jumbotron text-center">
                        <h2>Avast and welcome me-hearties!</h2>
                    </div>

                    <div class="jumbotron text-center">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 loginPanel">
                            <div class="container">
                                <button id="showLoginButton" class="btn btn-default btn-lg">LOGIN/SIGN UP</button>

                                    <ul class="list-unstyled whySignUp">
                                    <h4 class"toggle">Why sign up?</h4>
                                        <li><p>Save games</p></li>
                                        <li><p>Beat you best score</p></li>
                                        <li><p>Check your stats</p></li>
                                    </ul>
                                    </div>
                                    <div class="container hidden hiddenForms ">
                                    <form id="loginForm" class="form-horizontal" method="post" action="' . BASE. 'landing/login/">
                                      <div class="form-group usernameGroup">
                                        <label for="username" class="col-sm-2 control-label ">Username</label>
                                        <div class="col-sm-10">
                                          <input id="usernameInput" type="text" class="form-control" name="username" placeholder="e.g Long John Silver">
                                        </div>
                                      </div>
                                      <div class="form-group">
                                        <label for="password" class="col-sm-2 control-label">Password</label>
                                        <div class="col-sm-10">
                                          <input id="passwordInput" type="password" required class="form-control" name="password" placeholder="p@55WorD">
                                        </div>
                                      </div>
                                      <div class="form-group">
                                        <div class="col-sm-12">
                                        <button id="registerButton" type="button" class="btn btn-default">Register</button>
                                        <button id="loginButton" type="submit" class="btn btn-default">Login</button>
                                        <label><input type="checkbox" name="sli"> Stay signed in</label>
                                        </div>
                                      </div>
                                      <p id="loginMessage"></p>
                                </div>


                            </div>
                        </div>
                    </div>

                    <div class="container-fluid footer">
                    </div>


                </div>';
    return $content;

}