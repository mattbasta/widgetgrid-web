html.import_css('http://widgetgrid.com/assets/css/ytdemo.css');
if(request.platform != 'FBML') {
	html.import_css('http://frame.serverboy.net/latest.php');
}

var feed = 'http://gdata.youtube.com/feeds/users/' + request.param('user', 'bastawhiz') + '/uploads?orderby=updated';
var data = http.get(feed);

xml.parse(data);
xml.push("feed/entry");

var nodes = xml.count();

html.open_tag('div', 'container');
html.tag('h1', "Matt's YouTube Videos");

html.open_tag('ul');
for(var i=0;i<nodes;i++) {
	html.open_tag('li');
	
	html.open_tag('div', '', 'thumbnail');
	xml.save('stack');
	xml.push('media:group/media:thumbnail');
	var thumbcount = xml.count();
	var tadded = 0;
	var pthumb = '';
	for(var j=0;j<thumbcount;j++) {
		var url = xml.getvalue('url');
		if(url == "") {
			xml.shift();
			continue;
		}
		var height = xml.getvalue('height');
		if(height > 120) {
			xml.shift();
			continue;
		}
		var display = 'none';
		if(tadded==0) {
			display = 'block';
			pthumb = url;
		}
		tadded++;
		print('<img class="thumb" style="display:' + display + '" src="' + url + '" alt="" />');
		xml.shift();
	}
	xml.restore('stack');
	html.close_tag();
	
	var title = xml.getvalue("title");
	var desc = xml.getdeep("media:group/media:description");
	var link = xml.getdeep("media:group/media:player_attr/url");
	var views = xml.getdeep("yt:statistics_attr/viewCount");
	html.open_link(link);
		html.tag('strong', title);
	html.close_tag();
	html.tag('p', desc);
	html.tag('small', "Views: " + views);
	
	/*
	var swf = xml.getdeep("media:group/media:content/0_attr/url");
	html.flash(swf, 200, 150, pthumb);
	/**/
	
	xml.shift(); 
	html.close_tag();
}
html.close_tag();
html.close_tag();