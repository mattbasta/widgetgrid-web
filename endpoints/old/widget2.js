

var feed = 'http://widgetgrid.com/stuff.txt';
var data = '';
cache.get(feed, function(data) {
	if(data == '') {
		print('downloading');
		data = http.get(feed);
		cache.set(feed, data);
	}
	html.tag('p', data);
});