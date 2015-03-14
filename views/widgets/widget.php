<?php
$widget = view_manager::getvalue('WIDGET');

?>
<a class="g4" style="float:right;" href="/marker/<?php echo $widget['id']; ?>"><img src="/marker/<?php echo $widget['id']; ?>" height="300" width="300" /></a>
<section class="g8">
	<h1>Widget Editor</h1>
	<nav id="t_hnav">
		<ul>
			<li><a href="/widgets">My Widgets</a></li>
			<li class="current"><b><?php echo htmlentities($widget['title']); ?></b></li>
		</ul>
		<div class="clear">&nbsp;</div>
	</nav>
	<div class="clear">&nbsp;</div>
	<ul class="tabs">
		<?php $cpage = view_manager::getvalue('PAGE'); ?>
		<li<?php if($cpage=='') {echo ' class="current"';} ?>><a href="/widgets/<?php echo $widget['id']; ?>">Overview</a></li>
		<li<?php if($cpage=='setup') {echo ' class="current"';} ?>><a href="/widgets/<?php echo $widget['id']; ?>?setup">Setup</a></li>
		<li<?php if($cpage=='config') {echo ' class="current"';} ?>><a href="/widgets/<?php echo $widget['id']; ?>?config">Configuration</a></li>
		<li<?php if($cpage=='checkins') {echo ' class="current"';} ?>><a href="/widgets/<?php echo $widget['id']; ?>?checkins">Checkins</a></li>
		<li<?php if($cpage=='test') {echo ' class="current"';} ?>><a href="/widgets/<?php echo $widget['id']; ?>?test">Test</a></li>
	</ul>
	<div class="clear">&nbsp;</div>
	<?php echo view_manager::render(); ?>
</section>