<?php
/**
 * Created by PhpStorm.
 * User: jamesskywalker
 * Date: 04/06/2019
 * Time: 16:49
 */

function loadHeaderView($controller) {
    return '<div class="container">
                <nav class="navbar navbar-default navbar-static-top navbar-center">
                  <div class="container">
                    <ul class="list-unstyled list-inline text-center">
                        <li><a href="' . BASE . '">HOME</a></li>
                        <li><a href="' . BASE . 'home/logout">LOGOUT</a></li>
                    </ul>
                  </div>
                </nav>

            </div>';
}