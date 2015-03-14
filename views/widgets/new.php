<div class="g3">&nbsp;</div>
<div class="g6 loginbox">
	<header>
		<h1>Create a new widget</h1>
		<div class="clear"></div>
	</header>
	<form action="/widgets/new" method="post">
		<?php
		$form = getLib('form');
		echo $form->build('formtemplates/newwidget.xml');
		echo "<hr />";
		echo $form->render_options(
			array(
				'0'=>'Augmented Reality',
				'1'=>'Overlay'
			),
			'Display Mode',
			'display_style'
		);
		echo $form->hidden('submit', 'true');
		?>
		<label for="type">Application Type</label>
		<select name="type">
			<option value="0">Image</option>
			<option value="1">Javascript</option>
			<option value="2">Remote</option>
		</select>
		<p class="buttons">
			<input type="submit" value="Submit" />
		</p>
		<div class="clear"></div>
	</form>
</div>