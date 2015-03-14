<?php

header('Content-type: application/json');

$widget = array(
	"image"=>'',
	"actions"=>array( )
);

switch(intval($path[2]))
{
	case 1:
		$widget['image'] = 'http://widgetgrid.com/images/face.jpg';
		$widget['actions'] = array(
			array(
				"title"=>"Patrick Star",
				"type"=>"webpage",
				"action"=>"http://www.youtube.com/watch?v=bI1NoxBjg3M"
			),
			array(
				"title"=>"Hello, Krusty Krab?",
				"type"=>"text",
				"action"=>"NO, THIS IS PATRICK!"
			)
		);
		break;
	case 2:
	case 3:
	case 4:
	case 5:
		$widget['image'] = 'http://www.tylerlandis.com/hunt/hint.png';
		switch(intval($path[2]) + 2) {
			case 0: // First
				$widget['image'] = 'http://www.tylerlandis.com/hunt/start.png';
				$widget['actions'][] = array(
					  "title"=>"Start the Hunt!",
					  "type"=>"text",
					  "action"=>"CLUE: The next marker is 3 steps ahead of you!"
				);
				break;
			case 1:
				$widget['actions'][] = array(
					  "title"=>"Your Clue!",
					  "type"=>"text",
					  "action"=>"CLUE: The next marker is to your left!"
				);
				break;
			case 2:
				$widget['actions'][] = array(
					  "title"=>"Your Clue!",
					  "type"=>"text",
					  "action"=>"CLUE: The last marker is on the floor!"
				);
				break;
			case 3:
				$widget['image'] = 'http://www.tylerlandis.com/hunt/finish.png';
				$widget['actions'][] = array(
					  "title"=>"Congratulations!",
					  "type"=>"text",
					  "action"=>"Way to go! You finished our Scavenger Hunt! We hope you had fun."
				);
				break;
		}
		$widget['actions'][] = array(
			"title"=>"About Us",
			"type"=>"text",
			"action"=>"We're some college kids who made a scavenger hunt! So gather 'round, all ye hyenas and vultures! It's time for you to hunt at last!"
		);
		$widget['actions'][] = array(
			"title"=>"Our Website",
			"type"=>"webpage",
			"action"=>"http://widgetgrid.com/"
		);
		$widget['actions'][] = array(
			"title"=>"Tell a Friend",
			"type"=>"sms",
			"action"=>"You should check this out! http://www.widgetgrid.com"
		);
		break;
	case 6:
		$widget['image'] = 'http://widgetgrid.com/price.PNG';
		$widget['actions'] = array(
			array(
				"title"=>"Make Purchase",
				"type"=>"webpage",
				"action"=>"http://www.youtube.com/watch?v=bI1NoxBjg3M"
			),
			array(
				"title"=>"Share",
				"type"=>"sms",
				"action"=>"Check out these great prices!"
			)
		);
		break;
	case 7:
		
		$lat = $_REQUEST['lat'];
		$lon = $_REQUEST['lon'];
		
		$widget['image'] = "http://maps.google.com/maps/api/staticmap?center=$lat,$lon&zoom=13&size=300x300&sensor=true&key=ABQIAAAAX9G_p2F_3XQoRPUOusDoRRRv4j4BAEFd9AQEXUL5NIwAOCmBghTLY44yEYAOoX7kJe5HHldzJQLvTw";
		$widget['actions'] = array(
			array(
				"title"=>"View Map",
				"type"=>"webpage",
				"action"=>"http://maps.google.com/maps?f=q&source=s_q&hl=en&geocode=&sll=$lat,$lon&sspn=56.856075,114.169922&ie=UTF8&hq=moravian&hnear=&ll=$lat,$lon&spn=0.013484,0.027874&z=16&iwloc=B"
			),
			array(
				"title"=>"Street View",
				"type"=>"webpage",
				"action"=>"http://maps.google.com/maps?f=q&source=s_q&hl=en&geocode=&q=moravian&sll=$lat,$lon&sspn=56.856075,114.169922&ie=UTF8&hq=moravian&hnear=&ll=$lat,$lon&spn=0,359.972126&z=16&iwloc=B&layer=c&cbll=$lat,$lon&panoid=PijVXK8mC15aYQJCQYaV1g&cbp=12,224.5,,0,5.03"
			),
			array(
				"title"=>"Share",
				"type"=>"sms",
				"action"=>"Check out my location!"
			)
		);
		break;
}




echo json_encode($widget);