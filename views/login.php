<div class="g3">&nbsp;</div>
<section class="g6 loginbox">
	<header>
		<h1><?php echo view_manager::getvalue('DIALOGTITLE') ?></h1>
		<?php
		if($path[1] == '' || $path[1] == 'signin') {
			?><a class="alt-header" href="/login/signup">Don't have an account?</a><?
		}
		?>
		<div class="clear"></div>
	</header>
<?php
switch($path[1]) {
	case '':
	case 'signin':
		?>
		<form action="/login/go" method="post">
			<?php
			if(isset($_GET['invalid'])) {
				?>
				<p class="errors">
				You have entered an invalid email or password.
				</p>
				<?php
			}
			?>
			<label for="email"><span>Email:</span> <input type="text" name="email" /></label>
			<label for="password"><span>Password:</span> <input type="password" name="password" /></label>
			<p class="buttons">
				<input type="submit" value="Submit" />
				<a href="/login/forgot">Forgot my password</a>
			</p>
			<div class="clear"></div>
			<input type="hidden" name="action" value="login" />
		</form>
		<?php
		break;
	case 'signup':
		?>
		<form action="/login/go" method="post">
			<?php
			if(isset($_GET['invalid'])) {
				$errors = explode('-',$_GET['invalid']);
				echo '<p class="errors">';
				foreach($errors as $e) {
					if(empty($e))
						continue;
					switch($e) {
						case 'email':
							echo 'The email that you have provided is invalid.<br />';
							break;
						case 'again':
							echo 'The passwords you have entered do not match.<br />';
							break;
						case 'plen':
							echo 'The password must be at least seven characters long.<br />';
							break;
						case 'captcha':
							echo 'You did not correctly solve the math problem.<br />';
							break;
						case 'exists':
							echo 'The email you have chosen entered already exists.<br />';
							break;
					}
				}
				echo '</p>';
			}
			?>
			<label for="email"><span>Email:</span> <input type="text" name="email" /></label>
			<label for="password"><span>Password:</span> <input type="password" name="password" /></label>
			<label for="confirm"><span>Again:</span> <input type="password" name="confirm" /></label>
			<label for="math"><span><?php echo view_manager::getvalue('MATH'); ?></span> <input type="text" name="math" /></label>
			<p class="buttons">
				<input type="submit" value="Submit" />
			</p>
			<div class="clear"></div>
			<input type="hidden" name="action" value="signup" />
		</form>
		<?php
		break;
	case 'forgot':
		if(isset($_GET['done'])) {
			?>
			<div class="success_box">
				<strong>Success</strong>
				<p>We've sent out a new password for the account that you've specified. Please allow up to an hour for the email to arrive.</p>
			</div>
			<?php
		} elseif(isset($_GET['captcha'])) {
			?>
			<div class="warning_box">
				<strong>Invalid CAPTCHA</strong>
				<p>You did not correctly solve the math problem. Please try again.</p>
			</div>
			<?php
		}
		?>
		<form action="/login/go" method="post">
			<label for="email"><span>Email:</span> <input type="text" name="email" /></label>
			<label for="math"><span><?php echo view_manager::getvalue('MATH'); ?></span> <input type="text" name="math" /></label>
			<p class="buttons">
				<input type="submit" value="Submit" />
			</p>
			<div class="clear"></div>
			<input type="hidden" name="action" value="forgot" />
		</form>
		<?php
		break;
}
?>
</section>