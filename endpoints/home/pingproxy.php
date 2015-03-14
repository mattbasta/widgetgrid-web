<?php

if(!empty($_REQUEST['url'])) {
	
	$url = $_REQUEST['url'];
	
	$protocol = explode('://', $url);
	$protocol = $protocol[0];
	
	if($session->throttle === false) {
		$session->throttle = 0;
		$session->last_throttle = time();
	}
	$session->throttle = $session->throttle + 1;
	
	$rate = 0.25; // One request every four seconds
	
	$session->throttle = $session->throttle - (
		(time() - $session->last_throttle) * $rate
	);
	if($session->throttle > 100)
		die('Over rate limit');
	
	$session->last_throttle = time();
	
	switch($protocol) {
		case 'http':
		case 'https':
			break;
		default:
			die('Invalid request');
	}
	
	$data = file_get_contents($url);
	
	$x = new SimpleXMLElement($data);
	
	switch($x->getName()) {
		case 'widget':
			$output = array(
				'image'=>'http://widgetgrid.com/images/null.png',
				'actions'=>array()
			);
			$types = array(
				'text'=>true, 'sms'=>true, 'dial'=>true, 'streetview'=>true,
				'navigate'=>true, 'ping'=>true, 'webpage'=>true
			);
			if($x->image)
				$output['image'] = (string) $x->image;
			if($x->action) {
				foreach($x->action as $action) {
					
					if(!isset($types[(string)$action['type']]))
						continue;
					
					$output['actions'][] = array(
						'title'=>(string)$action->name,
						'type'=>(string)$action['type'],
						'action'=>(string)$action->value
					);
					
				}
			}
			echo json_encode(array('widget'=>$output));
			break;
		case 'runaction':
	}
	
}