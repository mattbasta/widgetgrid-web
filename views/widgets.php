<?php

$pagination = getLib('pagination');

$offset = $pagination->getOffset(50);

$widget_table = view_manager::getvalue('WIDGET_TABLE');

$my_widgets = $widget_table->fetch(
	array(
		'developer'=>$session->id
	),
	FETCH_RESULT,
	array(
		'order'=>new listorder('title', 'ASC'),
		'offset'=>$offset,
		'limit'=>50
	)
);

?>
<section class="g8">
	<h1>My Widgets</h1>
	<?php
	if($my_widgets->size() == 0) {
		?>
		<div class="notice_box">
			<strong>You have not created any widgets.</strong>
			<p>To create a new widget, visit the <a href="/widgets/new">widget creation</a> page.</p>
		</div>
		<?php
	} else {
	?>
	<p>Show widgets <?php echo $offset + 1; ?> to <?php echo min($offset + 51, $my_widgets->size()); ?> of <?php echo $my_widgets->size(); ?></p>
	<table>
		<tr>
			<th>Title</th>
			<th>Hits</th>
			<th>Edit</th>
		</tr>
		<?php
		while($widget = $my_widgets->next_array()) {
			?>
			<tr>
				<td><?php echo $widget['title']; ?></td>
				<td><?php echo $widget['hits']; ?></td>
				<td><a href="/widgets/<?php echo $widget['id']; ?>">Edit</a></td>
			</tr>
			<?php
		}
		?>
	</table>
	<p><?php
	echo $pagination->buildPaginationControls(
		'/widgetes/?p=%s',
		$my_widgets->size(),
		50,
		$pagination->getPage(),
		PAGE_STYLE_ADJACENT_FIVE,
		true
	);
	?></p>
	
	<?php
	}
	?>
</section>
<section class="g4 widgetsidebar">
	<a href="/widgets/new">Create a New Widget</a>
</section>