<?php
$widget = view_manager::getvalue('WIDGET');
$widget_actions = view_manager::getvalue('WIDGET_ACTIONS');

?>
<div class="g3 gfirst hits">
	<p>
		<b><?php echo $widget['hits']; ?></b>
		<span>hits</span>
	</p>
</div>
<div class="g5 glast">
	<p>
		Submitted: <?php echo date('F d, Y', (int)$widget['submitted']); ?>
	</p>
</div>