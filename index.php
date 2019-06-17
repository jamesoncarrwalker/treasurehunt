<?php
/**
 * Created by PhpStorm.
 * User: jamesskywalker
 * Date: 02/06/2019
 * Time: 19:29
 */

session_start();

header('Expires: Sat 26 Jul 1997 05:00:00 GMT');
header('Last-Modified: ' . gmdate('D, d M Y H:i:s' . ' GMT'));
header('Cache-control: cache, must-revalidate');
header('Pragma: public');

include ('private/core/global.php');
require_once('private/letsGetItOn.php');
new letsgetiton();
