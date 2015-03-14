var feed = 'http://gdata.youtube.com/feeds/users/' + request.param('user', 'bastawhiz') + '/uploads?orderby=updated';
var data = http.get(feed);

xml.parse(data);
xml.push("feed/entry");


