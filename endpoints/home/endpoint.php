<?php

view_manager::setvalue('TITLE', 'Widget Grid - Apps for the real world');

$db = cloud::create_db(
	'mysql',
	array(
		'username'=>'',
		'password'=>'',
		'database'=>'widgetgrid',
		'server'=>'localhost'
	)
);

if(!empty($path[0])) {
	switch($path[0]) {
		case 'account':
		case 'widgets':
			function getUser() {
				global $db, $session;
				$users = $db->get_table('developers');

				return $users->fetch(
					array(
						'id'=>$session->id
					),
					FETCH_SINGLE_TOKEN
				);

			}
		case 'login':
			view_manager::addview('shell');
		case 'widget':
		case 'imgproxy':
		case 'pingproxy':
		case 'marker':
			require(PATH_PREFIX . '/' . $path[0] . '.php');
			if(!defined('EXIT'))
				echo view_manager::render();
			break;
		default:
			header('HTTP/1.0 404 Not Found');
			readfile('./pages/fail.php');
	}
} else {
	$widget_table = $db->get_table('widgets');
	view_manager::setvalue('WIDGET_TABLE', $widget_table);
	view_manager::setvalue('WIDGET_COUNT', $widget_table->get_length());
	view_manager::addview('shell');
	view_manager::addview('home');
	echo view_manager::render();
}

$db->close();
