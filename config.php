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
	'telegramkey' => '1103187893:AAH8ytJHoVWgKO0ZYz2WuYCY1DN37n8p5Js',
	'telegramhost' => 'https://api.telegram.org/bot',
	'siteurl' => 'https://stg02.mobileforce.mobi/teleapi/undergroundbot/'
];

function _c($key) {
	global $configs;
	return (isset($configs[$key])) ? $configs[$key] : '';
}