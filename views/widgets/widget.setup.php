<?php
$widget = view_manager::getvalue('WIDGET');
$widget_actions = view_manager::getvalue('WIDGET_ACTIONS');

$form = getLib('form');

?>
<form id="wid_type" action="/widgets/<?php echo $widget['id']; ?>/update" method="post">
	<hr />
	<p class="inliner">
		<span>Widget Type: </span>
		<?php
		echo $form->render_options(
			array(
				'0'=>'Image',
				'1'=>'Javascript',
				'2'=>'Remote'
			),
			'',
			'type',
			$widget['type']
		);
		echo $form->hidden('action','type');
		?>
		<input type="submit" class="submit" value="Save" />
	</p>
	<hr />
</form>
<?php
$_code = <<<CODE
<widget>
<image>http://url/to/image</image>
<action type="action type">
	<name>The name of the action</name>
	<value>The action's payload</value>
</action>
<action type="action type">
	<name>The name of the action</name>
	<value>The action's payload</value>
</action>
</widget>
CODE;
$_code = htmlentities($_code);

switch((int)$widget['type']) {
	case 0:
?>
<div id="type_image">
	<img src="/images/imagematte.png" style="background:url('<?php
	if($widget['image_resource'] == '')
		echo '/images/null.png';
	else
		echo $widget['image_resource'];
	?>') no-repeat center center;" alt="Widget Image" id="image_preview" />
	
	<p>Image widgets display a simple image, which we'll host for you. Add actions below to make your widget interactive: add geolocation features, integrate a webpage, or even ping a remote API.</p>
	
	<form enctype="multipart/form-data" action="/widgets/<?php echo $widget['id']; ?>/image" method="post">
		<fieldset>
			<legend>Upload a new picture</legend>
			<?php
			echo $form->render_file_upload(
				'Upload a new image resource',
				'image',
				'This image will be used to represent your application.',
				"Upload a PNG file (under 1mb) that will be used as your widget's graphic."
			);
			?>
			<p class="buttons"><?php
				echo $form->submit('Upload Image');
			?></p>
		</fieldset>
	</form>
	<h2>Actions</h2>
	<form action="/widgets/<?php echo $widget['id']; ?>/actions" method="post">
		<?php
		if(isset($_GET['badaction'])) {
		?>
		<p class="errors">Invalid action data. You <em>must</em> have a name.</p>
		<?php
		}
		?>
		<table>
			<tr>
				<th>Name</th>
				<th>Type</th>
				<th>Resource</th>
				<th>Edit</th>
			</tr>
			<?php
			if($widget_actions === false || !is_array($widget_actions)) {
				?>
				<tr>
					<td colspan="4" style="text-align:center">There are currently no actions.</td>
				</tr>
				<?php
			} else {
				$types = array(
					'text'=>'Text', 'webpage'=>'Webpage', 'sms'=>'SMS Message',
					'ping'=>'HTTP Ping', 'dial'=>'Dial', 'navigate'=>'Navigate',
					'streetview'=>'Street View'
				);
				foreach($widget_actions as $action) {
					?>
					<tr>
						<td><?php echo htmlentities($action['name']); ?></td>
						<td><?php echo $action['type']; ?></td>
						<td><?php echo htmlentities($action['value']); ?></td>
						<td><a href="/widgets/<?php echo $widget['id']; ?>/actions/<?php echo $action['id']; ?>/delete">Delete</a></td>
					</tr>
					<?php
				}
			}
			?><tr>
				<td><input type="text" name="name" value="New widget action..." onblur="if(this.value==''){this.value = this.defaultValue;}" onfocus="if(this.value==this.defaultValue){this.value = '';}" /></td>
				<td>
					<select name="type">
						<option value="text">Text</option>
						<option value="webpage">Webpage</option>
						<option value="sms">SMS Message</option>
						<option value="ping">HTTP Ping</option>
						<option value="dial">Dial</option>
						<option value="navigate">Navigate</option>
						<option value="streetview">Street View</option>
					</select>
				</td>
				<td>
					<input type="text" name="value" value="Payload" />
				</td>
				<td>
					<input type="submit" class="submit" value="Add" />
				</td>
			</tr>
		</table>
	</form>
</div>
<?php
		break;
	case 1:
	
?>
<form id="type_js" action="/widgets/<?php echo $widget['id']; ?>/update" method="post">
	<?php
	echo $form->render(
		'textarea',
		'Javascript Source',
		'source',
		$widget['source']
	);
	echo $form->submit('Save Code');
	echo $form->hidden('action', 'source');
	?>
	<p>The code should <code>write( ... );</code> an XML snippet in the following format:</p>
	<code><?php echo $_code;?></code>
	<p>The interface allows you to take advantage of <a href="https://developer.mozilla.org/en/E4X">E4X</a>, making it extremely simple to produce this markup:</p>
	<code><span class="cm">////////////////////
// Logic goes here
////////////////////</span>
<tt>var</tt> <var>imageURL</var> = <kbd>"http://my/image/goes/here"</kbd>;
<tt>var</tt> <var>hint</var> = <kbd>"This is the hint"</kbd>;
<tt>var</tt> myOutput = <kbd>&lt;widget&gt;
&lt;image&gt;<var>{ imageURL }</var>&lt;/image&gt;
&lt;action type="text"&gt;
	&lt;name&gt;Click here for a hint&lt;/name&gt;
	&lt;value&gt;<var>{ hint }</var>&lt;/value&gt;
&lt;/action&gt;
&lt;action type="dial"&gt;
	&lt;name&gt;Call my cell&lt;/name&gt;
	&lt;value&gt;570-212-9663&lt;/value&gt;
&lt;/action&gt;
&lt;/widget&gt;</kbd>;
<b>write</b>(<var>myOutput</var>);
</code>
</form>
<?php
		break;
	case 2:
?>
<form id="type_remote" action="/widgets/<?php echo $widget['id']; ?>/update" method="post">
	<?php
	echo $form->render(
		'text',
		'Remote Resource URL',
		'source',
		$widget['source']
	);
	echo $form->submit('Save URL');
	echo $form->hidden('action', 'source');
	?>
	<p>Your URL should produce an XML snippet in the following format:</p>
	<code><?php echo $_code;?></code>
	<p>The <code>Content-Type</code> need not be anything particular.</p>
</form>
<?php
		break;
}
?>