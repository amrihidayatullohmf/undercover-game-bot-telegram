<?php
error_reporting(-1);
ini_set('display_errors', 1);
date_default_timezone_set('Asia/Jakarta');

$configs = [
	'dbhost' => '127.0.0.1',
	'dbuser' => 'root',
	'dbpassword' => '',
	'dbname' => 'undergroundbot',
	'dbprefix' => 'ub_',
	'telegramkey' => '',
	'telegramhost' => 'https://api.telegram.org/bot',
	'siteurl' => ''
];

function _c($key) {
	global $configs;
	return (isset($configs[$key])) ? $configs[$key] : '';
}