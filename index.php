<?php

define('BASE_DIR', getcwd());
define('FRAMEWORK_DIR', getcwd() . '/framework');

//Start engine

require('./framework/starter.php');

$app = new JaksonEngine(require('settings.php'));



?>
