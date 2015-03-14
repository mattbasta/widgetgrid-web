<div id="welcome" class="g9">
	<div id="phone"></div>
	<div id="phone2"></div>
	<div id="phone3"></div>
	<script type="text/javascript">
	<!--
	$(function() {
		$('#phone,#phone2,#phone3').hover(function() {
			$('#phone').stop().animate({
				height:'250px'
			});
			$('#phone2').stop().animate({
				height:'210px'
			});
			$('#phone3').stop().animate({
				height:'210px'
			});
		},function() {
			$('#phone').stop().animate({
				height:'200px'
			});
			$('#phone2').stop().animate({
				height:'140px'
			});
			$('#phone3').stop().animate({
				height:'175px'
			});
		});
	});
	-->
	</script>
	<p>Widget Grid lets you build mini mobile apps that run seamlessly on smartphones using augmented reality.</p>
	<div class="clear"></div>
</div>
<div class="clear"></div>
<?php

require(IXG_PATH_PREFIX . 'views/home/widget_count.php');

?>
<section class="g6">
	<p>Widget Grid allows you to create a new kind of software application: one that runs exclusively on mobile devices and interacts contextually with the real world. Widget Grid widgets are augmented reality applications that integrate geolocation, social networks, and real life object.</p>
</section>
<section class="g6 topwidgets">
	<h1>Top Widgets</h1>
	<?php
	$widget_table = view_manager::getvalue('WIDGET_TABLE');
	$widgets = $widget_table->fetch(
		array(
			new comparison(
				cloud::_st('secure'),
				'!=',
				1
			)
		),
		FETCH_ARRAY,
		array(
			'limit'=>5,
			'order'=>new listorder('hits', 'DESC'),
			'columns'=>array(
				'id',
				'title',
				'hits'
			)
		)
	);
	if($widgets !== false) {
	?>
	<table>
		<?php
		foreach($widgets as $widget) {
			?>
			<tr>
				<td><?php echo htmlentities($widget['title']); ?></td>
				<td><?php echo $widget['hits']; ?> hits</td>
			</tr>
			<?php
		}
		?>
	</table>
	<?php
	} else {
		?>
		<div class="notice_box">
			<strong>No Widgets</strong>
			<p>There are currently no widgets in the system.</p>
		</div>
		<?php
	}
	?>
</section>