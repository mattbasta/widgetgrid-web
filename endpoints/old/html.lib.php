<?

$htmlstack = array();

function html_open_tag($tag, $id=null, $class=null) {
	global $htmlstack;
	$tag = php_str($tag);
	if($id !== null)
		$id = php_str($id);
	if($class !== null)
		$class = php_str($class);
	
	$htmlstack[] = $tag;
	echo '<', $tag;
	if($id)
		echo ' id="', $id, '"';
	if($class)
		echo ' class="', $class, '"';
	echo '>';
}
function html_open_link($href, $id=null, $class=null) {
	global $htmlstack;
	$href = php_str($href);
	if($id !== null)
		$id = php_str($id);
	if($class !== null)
		$class = php_str($class);
	
	$htmlstack[] = 'a';
	echo '<a href="', $href, '"';
	if($id)
		echo ' id="', $id, '"';
	if($class)
		echo ' class="', $class, '"';
	echo '>';
}
function html_close_tag() {
	global $htmlstack;
	$tag = array_pop($htmlstack);
	echo '</', $tag, '>';
}

function html_tag($tag, $value) {
	$tag = php_str($tag);
	$value = php_str($value);
	echo "<$tag>$value</$tag>";
}

function html_flash($flash, $width, $height, $preview) {
	$flash = php_str($flash);
	$height = php_int($height);
	$width = php_int($width);
	$preview = php_str($preview);
	switch(PLATFORM) {
		case 'FBML':
			echo "<fb:swf swfsrc=\"$flash\" width=\"$width\" height=\"$height\" imgsrc=\"$preview\" />";
			break;
		default:
			echo <<<SWF
<embed src="$flash" width="$width" height="$height" type="application/x-shockwave-flash" allowscriptaccess="always" wmode="opaque" scale="showall" quality="high" bgcolor="#ffffff" />
SWF;
	}
}

function html_import_css($url) {
	$url = php_str($url);
	switch(PLATFORM) {
		case 'XHTML':
		case 'HTML5':
			echo '<link type="text/css" rel="stylesheet" href="', $url, '" />';
			break;
		case 'FBML':
			$data = soft_get($url);
			echo '<style>', $data, '</style>';
	}
}