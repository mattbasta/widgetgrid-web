<!DOCTYPE html>
<html>
<head>
	<title>Widget Grid</title>
	<!--[if IE]>
	<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]--> 
	<link type="text/css" rel="stylesheet" href="http://frame.serverboy.net/latest/" />
	<link type="text/css" rel="stylesheet" href="/css/css.css" />
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.2.6/jquery.min.js" type="text/javascript"></script>
</head>
<body class="med sans-serif use-code">
<div id="container">
	<header>
		<strong><a href="http://widgetgrid.com/">Widget Grid</a></strong>
		<section class="user">
			<div>
				<?php
				if($session->logged_in) {
					?><a href="/widgets">Widgets</a><!-- | <a href="/account">Account</a>--> | <a href="/login/logout">Sign Out</a><?php
				} else {
					?><a href="/login/signup">Sign Up</a> or <a href="/login">Sign In</a><?php
				}
				?>
			</div>
		</section>
		<div class="clear"></div>
	</header>
	<div class="wrap">
	<?php
	echo view_manager::render();
	?>
	<div class="clear">&nbsp;</div>
	</div>
	<footer>
		&copy; Copyright <?php echo date('Y'); ?>, <a href="http://serverboy.net/">Serverboy Software</a>
	</footer>
</div>
</body>
</html>