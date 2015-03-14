<?php

/*
	Available JS functions
*/

$memcache = new Memcache();
$memcache->connect('localhost', 11211) or die('Cannot connect to memcache');

// HTTP Namespace

function soft_get($url) {
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_TIMEOUT, 5);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	
	$output = curl_exec($ch);
	
	return $output;
}
function http_get($url) {
	$url = php_str($url);
	$output = soft_get($url);
	$output = js_str($output);
	return $output;
}
function http_post($url, $values) {
	$url = php_str($url);
	$values = php_str($values);
	
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_TIMEOUT, 5);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $values);
	
	$output = curl_exec($ch);
	
	$output = js_str($output);
	return $output;
}

// Cache Namespace

function cache_get($key) {
	global $memcache;
	$key = php_str($key);
	
	$mid = 'widgetgrid/user/' . md5(ACCOUNT) . '/' . sha1($key);
	$output = $memcache->get($mid);
	
	return js_str($output);
}

function cache_set($key, $value) {
	global $memcache;
	$key = php_str($key);
	$value = php_str($value);
	
	$mid = 'widgetgrid/user/' . md5(ACCOUNT) . '/' . sha1($key);
	$memcache->set($mid, $value, 0, 3600 * 24);
	
	return js_int(1);
}

// XML Namespace

function xml_xslt($feed, $transform) {
	$feed = php_str($feed);
	$transform = php_str($transform);
	
	$feed = http_get($feed);
	$transform = http_get($transform);
	
	$params = array(
		'/_xml' => $feed,
		'/_xslt' => $transform
	);
	
	$xslt = xslt_create();
	$output = xslt_process($xslt, 'arg:/_xml', 'arg:/_xslt', null, $params);
	xslt_free($xslt);
	
	return js_str($output);
}

require('xml.lib.php');

// Request Namespace

function request_param($name, $default) {
	$name = php_str($name);
	$default = php_str($default);
	if(isset($_REQUEST[$name]))
		return js_str($_REQUEST['name']);
	else
		return js_str($default);
}

// Crypt Namespace

function crypt_sha1($data) {
	$data = php_str($data);
	return js_str(sha1($data));
}
function crypt_md5($data) {
	$data = php_str($data);
	return js_str(md5($data));
}

// HTML Namespace

require('html.lib.php');

// Definitions

js::define(
	"http",
	array(
		"get" => "http_get",
		"post" => "http_post"
	)
);

js::define(
	"cache",
	array(
		"get" => "cache_get",
		"set" => "cache_set"
	)
);

js::define(
	"xml",
	array(
		"xslt" => "xml_xslt",
		"parse" => "xml2array",
		"count" => "xml_count",
		"push" => "xml_push",
		"getvalue" => "xml_getvalue",
		"getdeep" => "xml_getdeep",
		"save" => "xml_save",
		"restore" => "xml_restore",
		"shift" => "xml_shift",
		"clear" => "xml_clear"
	)
);

js::define(
	"request",
	array(
		"param" => "request_param"
	),
	array(
		'platform' => PLATFORM,
		'account' => ACCOUNT
	)
);

js::define(
	"crypt",
	array(
		"sha1" => "crypt_sha1",
		"md5" => "crypt_md5"
	)
);

js::define(
	"html",
	array(
		"open_tag" => "html_open_tag",
		"open_link" => "html_open_link",
		"close_tag" => "html_close_tag",
		"import_css" => "html_import_css",
		"flash" => "html_flash",
		"tag" => "html_tag"
	)
);
