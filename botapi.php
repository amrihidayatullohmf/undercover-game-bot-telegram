<?php 
require_once('config.php');
require_once('system/Dbhelper.php');
require_once('system/Modelhelper.php');
require_once('system/Telegramhelper.php');

$output = file_get_contents('php://input');

$model = new Modelhelper($dbhelper);
$telegram = new Telegramhelper($configs);

$info = $telegram->extractChatInformation($output);
$model->loginfo($info);

if($info) {
	$text = $info['text'];
	$chatID = $info['chatID'];

	if($text == '/start') {
		if($telegram->isValidUser()) {
			if(!$model->isUserExist($info['chatID'])) {
				$save = $model->insertUser($info['chatID'],$info['fullName'],$info['userName'],$info['phone']);
				if(isset($save) and $save != FALSE) {
					$telegram->sendMessage('Selamat datang dan bergabung dengan UndergroundxMobileForce game ini '.$info['fullName'].'. Silahkan bergabung ke group chat telegram lainnya, dan mulai bermain dengan teman - teman kamu !');
				}
			} else {
				$telegram->sendMessage('Hi '.$info['fullName'].'. Kamu sudah terdaftar, Silahkan bergabung ke group chat telegram lainnya, dan mulai bermain dengan teman - teman kamu !');
			}
		}
	} else if($text == '/startnewgame') {

	} else if($text == '/joingame') {

	} else if($text == '/startgame') {

	} else if($text == '/startvote') {

	} else if($text == '/resetgame') {

	} 
}

