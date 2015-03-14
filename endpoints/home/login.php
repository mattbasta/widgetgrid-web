<?php

view_manager::setvalue('DIALOGTITLE', 'Sign In');
if(isset($path[1])) {
	switch($path[1]) {
		case 'go':
			if(isset($_REQUEST['action'])) {

				switch($_REQUEST['action']) {
					case 'login':

						// We always want the email to be lowercase
						$email = strtolower($_REQUEST['email']);

						$user_table = $db->get_table('developers');
						$user = $user_table->fetch(
							array(
								'email'=>$email, // Not to worry, Cloud escapes this out for us
								'password'=>sha1($_REQUEST['password'])
							),
							FETCH_SINGLE,
							array(
								'columns'=>'id'
							)
						);

						// Tell the user that they did something wrong
						if($user === false) {
							header('Location: /login/?invalid');
							break;
						}

						$session->logged_in = true;
						$session->email = $email;
						$session->id = $user;
						header('Location: /widgets');

						break;

					case 'signup':

						$user_table = $db->get_table('developers');


						if(!validEmail($_REQUEST['email']))
							$error = 'email';
						elseif($user_table->fetch_exists(array(
							'email'=>$_REQUEST['email']
						)))
							$error .= '-exists';

						if($_REQUEST['password'] != $_REQUEST['confirm'])
							$error .= '-again';
						if(strlen($_REQUEST['password']) < 7)
							$error .= '-plen';
						if($session->captcha != $_REQUEST['math'])
							$error .= '-captcha';

						if(!empty($error)) {
							header('Location: /login/signup?invalid=' . $error);
							exit;
						}

						$user_table->insert_row(
							0,
							array(
								'email'=>$_REQUEST['email'],
								'password'=>sha1($_REQUEST['password']),
								'joined'=>time()
							)
						);

						$session->logged_in = true;
						$session->email = $_REQUEST['email'];
						header('Location: /widgets');

						break;
					case 'forgot':

						// Did the user fail the CAPTCHA?
						if($session->captcha == $_REQUEST['math']) {

							$user_table = $db->get_table('developers');

							$dev = $user_table->fetch(
								array(
									'email'=>$_REQUEST['email'] // Sanitized by Cloud
								),
								FETCH_SINGLE_TOKEN
							);

							if($dev === false) {
								// We don't want to warn the user that they entered
								// a bad email, because that could tip off spammers.
								header('Location: /login/forgot?done');
								break;
							}

							include("Mail.php");

							$headers = array(
								'From'=>'noreply@widgetgrid.com',
								'To'=>$dev->email,
								'Subject'=>'Password Retrieval'
							);
							$params = array(
								'host'=>'smtpout.secureserver.net',
								'port'=>25,
								'auth'=>true,
								'username'=>'',
								'password'=>''
							);

							$newpass = substr(md5(uniqid()), 0, 10);
							$body = <<<EMAIL
Hi, we're emailing you because someone over at Widget Grid requested a password change for your account. The new password for your account is as follows:

$newpass

This change will be reflected by your account immediately. Please do not reply to this email.

Thanks,
The Widget Grid Team
http://widgetgrid.com/

EMAIL;

							$dev->password = sha1($newpass);

							$mail = Mail::factory('smtp', $params);
							$mail->send(
								$dev->email,
								$headers,
								$body
							);

							header('Location: /login/forgot?done');

						} else
							header('Location: /login/forgot?captcha');
				}
			} else
				echo "Nothing to do.";

			define('EXIT', true);

			break;
		case 'signup':
			view_manager::setvalue('DIALOGTITLE', 'Create an Account');
			$num1 = rand(5,10);
			$num2 = rand(11,90);
			$pm = rand(0,1) * 2 - 1;
			$session->captcha = $num2 + ($pm * $num1);

			view_manager::setvalue('MATH', $num2 . ($pm < 0 ? ' - ' : ' + ') . $num1 . ' = ');
			break;
		case 'forgot':
			view_manager::setvalue('DIALOGTITLE', 'Password Retrieval');
			$num1 = rand(5,10);
			$num2 = rand(11,90);
			$pm = rand(0,1) * 2 - 1;
			$session->captcha = $num2 + ($pm * $num1);

			view_manager::setvalue('MATH', $num2 . ($pm < 0 ? ' - ' : ' + ') . $num1 . ' = ');
			break;
		case 'password':
			view_manager::setvalue('DIALOGTITLE', 'Change Password');
			break;
		case 'logout':
		case 'signout':
			$session->destroy();
			header('Location: http://' . DOMAIN . '/');
			break;
	}
}

if(!defined('EXIT')) {
	view_manager::setvalue('TITLE', 'Widget Grid - Account Management');
	view_manager::addview('login');
}
