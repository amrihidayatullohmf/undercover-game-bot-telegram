<?php 
require_once('config.php');
require_once('system/Telegramhelper.php');

$telegram = new Telegramhelper($configs);
$output = $telegram->setWebHook();

var_dump($output);