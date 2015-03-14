<?php
$widget = view_manager::getvalue('WIDGET');
$widget_actions = view_manager::getvalue('WIDGET_ACTIONS');

$form = getLib('form');

?>
<form action="/widgets/<?php echo $widget['id']; ?>/update" method="post">
	<fieldset>
		<legend>Basic Settings</legend>
		
		<?php
		echo $form->render(
			'text',
			'Widget Title',
			'title',
			$widget['title']
		);
		echo $form->render_checkgroup(array(
			array(
				'label'=>'Secure Widget',
				'name'=>'secure',
				'value'=>'true',
				'checked'=>(intval($widget['secure']) == '1')
			),
			array(
				'label'=>'Don\'t Cache',
				'name'=>'no_cache',
				'value'=>'true',
				'checked'=>(intval($widget['no_cache']) == '1')
			),
			array(
				'label'=>'Allow Purchases',
				'name'=>'may_purchase',
				'value'=>'true',
				'checked'=>(intval($widget['may_purchase']) == '1')
			),
		));
		?>
		<?php
		echo $form->render_options(
			array(
				'0'=>'Augmented Reality',
				'1'=>'Screen Overlay'
			),
			'Display Mode',
			'display_style',
			$widget['display_style']
		);
		echo $form->hidden('action', 'update');
		?>
		<p class="buttons"><?php
			echo $form->submit('Save Widget Details');
		?></p>
	</fieldset>
</form>