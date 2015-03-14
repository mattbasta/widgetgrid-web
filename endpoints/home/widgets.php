<?php

if(!$session->logged_in) {
	header('Location: http://widgetgrid.com/login');
	break;
}

if(isset($path[1])) {
	$widget_table = $db->get_table('widgets');
	$widget_actions_table = $db->get_table('widget_actions');
	
	switch($path[1]) {
		case 'new':
			
			if(isset($_REQUEST['submit'])) {
				
				if(	empty($_REQUEST['title']) ||
					!isset($_REQUEST['type']) ||
					!isset($_REQUEST['display_style'])) {
					header('Location: http://widgetgrid.com/widget/new?invalid');
					define('EXIT',true);
					break;
				}
				
				$type = (int) $_REQUEST['type'];
				if($type < 0 || $type > 2) {
					echo 'Invalid request';
					break;
				}
				
				$sgclient = new Services_SimpleGeo('6KMpJ9J9qG2ah3nF2w2Bs6u54RePKnRw', '4CxmTguvaaS9vU8fcHREXtj4L5zC3dTP');
				
				$newid = $widget_table->insert_row(
					0,
					array(
						'title'=>$_REQUEST['title'],
						'submitted'=>time(),
						'developer'=>$session->id,
						'source'=>'',
						'hits'=>0,
						'image_resource'=>'',
						'display_style'=>(($_REQUEST['display_style']=='1') ? 1 : 0),
						'secure'=>isset($_REQUEST['secure']),
						'no_cache'=>isset($_REQUEST['no_cache']),
						'may_purchase'=>isset($_REQUEST['may_purchase'])
					)
				);
				function locateIp($ip){
					$d = file_get_contents("http://www.ipinfodb.com/ip_query.php?ip=$ip&output=xml&timezone=false");

					//Use backup server if cannot make a connection
					if (!$d){
						$d = file_get_contents("http://backup.ipinfodb.com/ip_query.php?ip=$ip&output=xml&timezone=false");
						if (!$d) return false; // Failed to open connection
						$answer = new SimpleXMLElement($backup);
					}
					$answer = new SimpleXMLElement($d);
					
					return array(
						$answer->Latitude,
						$answer->Longitude
					);
				}
				$iploc = locateIp($_SERVER['HTTP_CLIENT_IP']);
				
				$geo = new Services_SimpleGeo_Record(
					'com.widgetgrid.widgets',
					$newid,
					$iploc[0],
					$iploc[1],
					'object'
				);
				$geo->userid = $session->id;
				$sgclient->addRecord($geo);
				
				header('Location: /widgets/' . $newid);
				define('EXIT', true);
				break;
			}
			
			view_manager::addview('widgets/new');
			break;
			
		default:
			$widget_id = intval($path[1]);
			$widget_actions_table = $db->get_table('widget_actions');
			
			$widget = $widget_table->fetch(
				array(
					'developer'=>$session->id,
					'id'=>$widget_id
				),
				FETCH_SINGLE_ARRAY
			);
			if($widget == false) {
				echo 'Invalid widget';
				break;
			}
			
			
			if(isset($path[2])) {
				$val = $path[2];
				
				switch($val) {
					case 'update':
						
						if(!isset($_POST['action'])) {
							echo 'No action';
							define('EXIT',true);
							break;
						}
						
						switch($_POST['action']) {
							case 'update':
								
								if(	empty($_REQUEST['title']) ||
									!isset($_REQUEST['display_style'])) {
									
									echo 'Invalid request';
									define('EXIT',true);
									break;
								}
								
								$widget_table->update_row(
									$widget['id'],
									array(
										'title'=>$_REQUEST['title'],
										'secure'=>isset($_REQUEST['secure']),
										'no_cache'=>isset($_REQUEST['no_cache']),
										'may_purchase'=>isset($_REQUEST['may_purchase']),
										'display_style'=>($_REQUEST['display_style'] == '0') ? 0 : 1
									)
								);
								define('TAG', 'config');
								
								break;
							case 'type':
								$val = (int)$_POST['type'];
								if($val > 2 || $val < 0) {
									echo 'Invalid value';
									define('EXIT',true);
									break;
								}
								
								$widget_table->update_row(
									$widget_id,
									array(
										'type'=>$val,
										'source'=>''
									)
								);
								
								define('TAG', 'setup');
								break;
							
							case 'source':
								
								$widget_table->update_row(
									$widget_id,
									array(
										'source'=>$_REQUEST['source']
									)
								);
								define('TAG', 'setup');
								
								break;
						}
						break;
					
					case 'image':
						
						if(!isset($_FILES['image']))
							die('No image provided');
						if((int)$_FILES['image']['size'] > 1000000)
							die('The image you have chosen is too big.');
						
						$newid = md5(uniqid());
						
						$target = $_FILES['image']['tmp_name'];
						
						switch($_FILES['image']['type']) {
							case 'image/jpeg':
								$im = imagecreatefromjpeg($target);
								$extension = 'jpg';
								break;
							case 'image/png':
								$im = imagecreatefrompng($target);
								$extension = 'png';
								break;
							case 'image/gif':
								$im = imagecreatefromgif($target);
								$extension = 'gif';
								break;
						}
						
						$_w = imagesx($im);
						$_h = imagesy($im);
						
						$dim = imagecreatetruecolor(300,300);
						
						$x = min($_w, $_h);
						
						imagecopyresampled($dim, $im, 0, 0, $_w / 2 - $x / 2, $_h / 2 - $x / 2, 300, 300, $x, $x);
						
						switch($_FILES['image']['type']) {
							case 'image/jpeg':
								imagejpeg($dim, $target);
								break;
							case 'image/png':
								imagepng($dim, $target);
								break;
							case 'image/gif':
								imagegif($dim, $target);
								break;
						}
						imagedestroy($dim);
						imagedestroy($im);
						
						
						$s = new S3('01XY0ZANWYBYT0Q25J02', '1atdGGWXUtPMpNwJnFyvTdIVMJWIXAh5wzEliQTd');
						
						$s->putObject(
							S3::inputFile($target),
							'com.widgetgrid',
							"imageresources/$newid.$extension",
							S3::ACL_PUBLIC_READ
						);
						if(!empty($widget['image_resource'])) {
							$s->deleteObject(
								'com.widgetgrid',
								"imageresources/" . substr($widget['image_resource'], 54)
							);
						}
						unlink($target);
						
						$widget_table->update_row(
							$widget['id'],
							array(
								'image_resource'=>"http://com.widgetgrid.s3.amazonaws.com/imageresources/$newid.$extension"
							)
						);
						
						define('TAG', 'setup');
						
						break;
					
					case 'actions':
						
						define('TAG', 'setup');
						
						if(!empty($path[3])) {
							$actionid = intval($path[3]);
							
							if(empty($path[4]) || $path[4] != 'delete') {
								header('Location: http://widgetgrid.com/widgets/' . $widget['id'] . '/?badaction');
								exit;
							}
							
							$action = $widget_actions_table->fetch(
								array(
									'id'=>$actionid,
									'widget'=>$widget['id']
								),
								FETCH_SINGLE_TOKEN
							);
							$action->destroy();
							
							break;
							
						}
						
						$types = array(
							'text'=>true, 'webpage'=>true, 'sms'=>true,
							'ping'=>true, 'dial'=>true, 'navigate'=>true,
							'streetview'=>true
						);
						
						if(	empty($_REQUEST['name']) ||
							empty($_REQUEST['type']) ||
							!isset($types[$_REQUEST['type']])) {
							
							header('Location: http://widgetgrid.com/widgets/' . $widget['id'] . '/?badaction');
							define('EXIT',true);
							break;
						}
						
						$widget_actions_table->insert_row(
							0,
							array(
								'widget'=>$widget['id'],
								'name'=>$_REQUEST['name'],
								'type'=>$_REQUEST['type'],
								'value'=>$_REQUEST['value']
							)
						);
						
						
				}
				
				if(!defined('EXIT')) {
					header('Location: http://widgetgrid.com/widgets/' . $path[1] . (defined('TAG')?'?'.TAG:''));
					define('EXIT', true);
				}
				break;
				
			}
			
			view_manager::setvalue('WIDGET',$widget);
			
			$widget_actions = $widget_actions_table->fetch(
				array(
					'widget'=>$widget_id
				),
				FETCH_ARRAY
			);
			view_manager::setvalue('WIDGET_ACTIONS',$widget_actions);
			view_manager::setvalue('PAGE', '');
			view_manager::addview('widgets/widget');
			
			if(isset($_REQUEST['setup'])) {
				
				view_manager::setvalue('PAGE', 'setup');
				view_manager::addview('widgets/widget.setup');
				
			} elseif(isset($_REQUEST['config'])) {
				
				view_manager::setvalue('PAGE', 'config');
				view_manager::addview('widgets/widget.configuration');
				
			} elseif(isset($_REQUEST['checkins'])) {
				
				view_manager::setvalue('PAGE', 'checkins');
				view_manager::setvalue('WIDGET_CHECKINS',$db->get_table('checkins'));
				view_manager::addview('widgets/widget.checkins');
				
			} elseif(isset($_REQUEST['test'])) {
				
				view_manager::setvalue('PAGE', 'test');
				view_manager::addview('widgets/widget.test');
				
			} else
				view_manager::addview('widgets/widget.overview');
	}
	
} else {
	view_manager::setvalue('WIDGET_TABLE', $db->get_table('widgets'));
	view_manager::addview('widgets');
}