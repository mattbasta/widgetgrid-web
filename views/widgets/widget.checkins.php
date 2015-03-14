<?php
$widget = view_manager::getvalue('WIDGET');
$widget_checkins = view_manager::getvalue('WIDGET_CHECKINS');

$form = getLib('form');

?>
<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;sensor=false&amp;key=ABQIAAAAX9G_p2F_3XQoRPUOusDoRRRv4j4BAEFd9AQEXUL5NIwAOCmBghTLY44yEYAOoX7kJe5HHldzJQLvTw" type="text/javascript"></script>
<div id="map" style="height:500px;"></div>
<script type="text/javascript">
<!--
window.onload = function() {
	var map = new GMap2(document.getElementById("map"));
	map.setCenter(new GLatLng(40, -100), 3);
	map.setUIToDefault();
	
	var blueIcon = new GIcon(G_DEFAULT_ICON);
	markerOptions = { icon:blueIcon };
	
	var point;
	
	<?php
	$checkins = $widget_checkins->fetch(
		array(
			'widget'=>$widget['id']
		),
		FETCH_ARRAY,
		array(
			'limit'=>50
		)
	);
	$ci = array();
	if($checkins !== false) {
		foreach($checkins as $checkin) {
			?>
			point = new GLatLng(<?php echo $checkin['lat']; ?>, <?php echo $checkin['lon']; ?>);
			map.addOverlay(new GMarker(point, markerOptions));
			<?php
		}
	}
	?>
	
};

-->
</script>