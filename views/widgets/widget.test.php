<?php
$widget = view_manager::getvalue('WIDGET');
?>
<script type="text/javascript" defer>
<!--

document.action = function(type, value) {
	switch(type) {
		case 'text':
			alert(value);
			break;
		case 'webpage':
			window.open(value);
			break;
		case 'sms':
			alert('New SMS created with body: ' + value);
			break;
		case 'ping':
			var yql = 'http://widgetgrid.com/pingproxy?url=' + encodeURIComponent(value);
			$.getJSON( yql, function(data) {
				if(data.widget) {
					document.load_widget(data.widget);
				}else if(data.runaction) {
					
				}
			});
			break;
		case 'navigate':
			window.open('http://maps.google.com/maps?f=q&source=s_q&hl=en&geocode=&q=' + value);
			break;
		case 'streetview':
			window.open('http://maps.google.com/maps?f=q&layer=c&cbll=' + value + '&cbp=12,142.66,,0,5');
			break;
			
	}
	document.getElementById('td_dialog').className='hide';
};
document.loaddialog = function() {
	if(document.actioncount == 0) {
		alert('No specified actions.');
		return;
	}
	document.getElementById('td_dialog').className='';
	
};
document.actioncount = 0;

document.load_widget = function(data) {
	if(!!data.image)
		document.getElementById('td_widget').src=data.image;
	document.getElementById('td_dialog').innerHTML='';
	var ul = document.createElement('ul');
	for(a in data.actions) {
		var action = data.actions[a];
		var li = document.createElement('li');
		var ah = document.createElement('a');
		ah.href = '#';
		ah.innerHTML = action.title;
		ah.value = action.action;
		ah.wtype = action.type;
		ah.onclick = function() {
			document.action(this.wtype, this.value);
			return false;
		};
		li.appendChild(ah);
		ul.appendChild(li);
		document.actioncount++;
	}
	$('#td_dialog').append(ul);
};

$(document).ready(function() {
	$.getJSON(
		'/widget/<?php echo $widget['id'] ?>',
		document.load_widget
	);
});

-->
</script>
<div id="testdevice">
	<div id="td_canvas">
		<a href="#" onclick="document.loaddialog();return false;"><img id="td_widget" src="/images/null.png" alt="" /></a>
		<div id="td_dialog" class="hide"></div>
	</div>
</div>
<p>The widget emulator above shows you what your widget would look like on an Android device running the AR software. Clicking your widget's image will show the actions dialog.</p>