<?php

if(isset($path[1])) {
	
	$widget_table = $db->get_table('widgets');
	
	// Get the requested widget
	$widget = $widget_table->fetch(
		array(
			'_primary_key'=>intval($path[1]) // Escaped by Cloud
		),
		FETCH_SINGLE_TOKEN
	);
	
	// What if we don't find it?
	if($widget === false) {
		header('HTTP/1.0 404 Not Found');
		echo 'Widget Not Found';
		break;
	}
	
	if(isset($path[2]) && $path[2] == 'script' && intval($widget->type) == 1) {
		
		if(empty($_GET['timestamp']) || empty($_GET['token'])) {
			header('HTTP/1.0 404 Not Found');
			echo "Invalid headers";
			break;
		}
		
		$timestamp = intval($_GET['timestamp']);
		$token = $_GET['token'];
		
		$delay = time() - $timestamp;
		if($delay > 10 || $delay < 0)
			die("Invalid timestamp");
		
		$new_token = $path[1] . $timestamp . $widget_secret;
		$new_token = sha1($new_token);
		
		if($new_token != $token)
			die('Invalid token');
		
		echo $widget->source;
		
	} else {
		
		$output = array(
			'image' => 'http://widgetgrid.com/images/null.png',
			'actions' => array(),
			'secure' => $widget->secure == '1',
			'display_style' => $widget->display_style,
			'no_cache' => $widget->no_cache == '1'
		);
		
		switch((int)$widget->type) {
			case 0: // Image
				
				$output['image'] = $widget->image_resource;
				
				$actions_table = $db->get_table('widget_actions');
				$actions = $actions_table->fetch(
					array(
						'widget'=>$widget->id
					),
					FETCH_TOKENS
				);
				
				if($actions != false) {
					foreach($actions as $action) {
						$output['actions'][] = array(
							'title'=>$action->name,
							'type'=>$action->type,
							'action'=>$action->value
						);
					}
				}
				
				break;
			case 1: // Local
				
				$timestamp = time();
				$token = sha1($widget->id . $timestamp . $widget_secret);
				
				$resource = 'http://linode2.server.serverboy.net/notex.cgi?script=';
				$resource .= urlencode('http://widgetgrid.com/widget/' . $widget->id . '/script?timestamp=' . time() . '&token=' . $token);
				
				
			case 2: // Remote
				
				$data = docurl(empty($resource) ? $widget->source : $resource);
				
				$x = new SimpleXMLElement($data);
				
				$output['image'] = (string) $x->image;
				$types = array(
					'text'=>true, 'sms'=>true, 'dial'=>true, 'streetview'=>true,
					'navigate'=>true, 'ping'=>true, 'webpage'=>true
				);
				foreach($x->action as $action) {
					
					if(!isset($types[(string)$action['type']]))
						continue;
					
					$output['actions'][] = array(
						'title'=>(string)$action->name,
						'type'=>(string)$action['type'],
						'action'=>(string)$action->value
					);
					
				}
				
				break;
		}
		
		$widget->hits = intval($widget->hits) + 1;
		
		if(isset($_REQUEST['hasLocation'])) {
			$lat = (double)$_REQUEST['lat'];
			$lon = (double)$_REQUEST['lon'];
			$acc = (int)$_REQUEST['accuracy'];
			
			
			$checkin_table = $db->get_table('checkins');
			$checkin_table->insert_row(
				0,
				array(
					'widget'=>(int)$widget->id,
					'lat'=>$lat,
					'lon'=>$lon,
					'accuracy'=>$acc,
					'position'=>new cloud_unescaped("GeomFromText('POINT($lat $lon)')"),
					'userid'=>$_REQUEST['account'],
					'timestamp'=>time()
				)
			);
			
			$sgclient = new Services_SimpleGeo('6KMpJ9J9qG2ah3nF2w2Bs6u54RePKnRw', '4CxmTguvaaS9vU8fcHREXtj4L5zC3dTP');
			
			$checkin = new Services_SimpleGeo_Record(
				'com.widgetgrid.checkins' . (($widget->secure == '1') ? '.secure' : ''),
				uniqid(),
				$lat,
				$lon,
				'object'
			);
			$checkin->widget = $widget->id;
			$checkin->accuracy = $acc;
			
			$sgclient->addRecord($checkin);
			
			
		}
		
		header('Content-type: application/json');
		echo json_encode($output);
		flush();
		
	}
	
} else
	header('Location: http://widgetgrid.com/');
