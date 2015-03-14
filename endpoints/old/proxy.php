<?php

if(!isset($_REQUEST['url']))
	die('Invalid Call');

function soft_get($url) {
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_TIMEOUT, 5);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	
	$output = curl_exec($ch);
	
	return $output;
}

function soft_post($url) {
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_TIMEOUT, 5);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $_POST['values']);
	
	$output = curl_exec($ch);
	
	return $output;
}

set_time_limit(5);

if($_SERVER['REQUEST_METHOD'] == 'GET')
	echo soft_get($_REQUEST['url']);
else
	echo soft_post($_REQUEST['url']);