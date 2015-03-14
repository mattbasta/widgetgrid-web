<?php

if(!isset($_REQUEST['platform']))
	$_REQUEST['platform'] = 'xhtml';
define('PLATFORM', strtoupper($_REQUEST['platform']));

$js = file_get_contents($_REQUEST['file'] . '.js');

if(PLATFORM == 'HTML5')
	echo '<!DOCTYPE HTML>';

$wrapper_started = false;
switch(PLATFORM) {
	case 'XHTML':
	case 'REMOTE_XHTML':
		require('provider.php');
	case 'LOCAL':
	case 'LOCAL_HTML':
	case 'GEARS':
		echo '<html><head><title>Widget</title></head><body class="mla med sans-serif;">';
		$wrapper_started = true;
		break;
	case 'HTML5':
		echo '<html manifest="cache-manifest"><head><title>Widget</title></head><body class="mla med sans-serif">';
		$wrapper_started = true;
		
}
switch(PLATFORM) {
	case 'GEARS':
		echo '<script type="text/javascript" src="/gears_init.js"></script>';
	case 'HTML5':
	case 'LOCAL':
	case 'LOCAL_XHTML':
		echo '<script type="text/javascript" src="/wrapper.js"></script>';
		echo '<script type="text/javascript">', $js, '</script>';
		break;
	case 'REMOTE':
	case 'REMOTE_XHTML':
	default:
		$js_header = file_get_contents('header.js');
		$js = $js_header . $js;
		js::run($js);
}
if($wrapper_started)
	echo '</body></html>';

//var_dump($xmlondeck);
