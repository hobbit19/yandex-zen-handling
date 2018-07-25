<?php

/**
 *  Bot's command runner
 */

ini_set("display_errors", "0");

include 'bootstrap.php';

use lib\Bot;

$bot = new Bot();
$bot->runCommands();