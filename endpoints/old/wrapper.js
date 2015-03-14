
function write(x) {document.write(x);}

var html = {
	stack : [],
	open_tag : function(tag, id, classVal){
		html.stack[html.stack.length] = tag;
		document.write(
			'<' + tag +
			(id ? ' id="' + id + '"' : '') + 
			(classVal ? ' class="' + classVal + '"' : '') +
			'>'
		);
	},
	open_link : function(href, id, classVal){
		html.stack[html.stack.length] = 'a';
		document.write(
			'<a href="' + href + '"' +
			(id ? ' id="' + id + '"' : '') + 
			(classVal ? ' class="' + classVal + '"' : '') +
			'>'
		);
	},
	close_tag : function() {
		var narr = [];
		var tag = html.stack[html.stack.length - 1];
		document.write('</' + tag + '>');
		for(var i=0;i<html.stack.length - 1;i++)
			narr[i] = html.stack[i];
		html.stack = narr;
	},
	tag : function(tag, value) {
		html.open_tag(tag);
		document.write(value);
		html.close_tag();
	},
	flash : function(flash, width, height, preview) {
		document.write('<embed src="' + flash + '" width="' + width + '" height="' + height + '" type="application/x-shockwave-flash" allowscriptaccess="always" wmode="opaque" scale="showall" quality="high" bgcolor="#ffffff" />');
	},
	import_css : function(url) {
		document.write('<link type="text/css" rel="stylesheet" href="' + url + '" />');
	}
};

var hexcase=0;
var b64pad="";function sha1(a){return rstr2hex(rstr_sha1(str2rstr_utf8(a)))}function hex_hmac_sha1(a,b){return rstr2hex(rstr_hmac_sha1(str2rstr_utf8(a),str2rstr_utf8(b)))}function sha1_vm_test(){return sha1("abc").toLowerCase()=="a9993e364706816aba3e25717850c26c9cd0d89d"}function rstr_sha1(a){return binb2rstr(binb_sha1(rstr2binb(a),a.length*8))}function rstr_hmac_sha1(c,f){var e=rstr2binb(c);if(e.length>16){e=binb_sha1(e,c.length*8)}var a=Array(16),d=Array(16);for(var b=0;b<16;b++){a[b]=e[b]^909522486;d[b]=e[b]^1549556828}var g=binb_sha1(a.concat(rstr2binb(f)),512+f.length*8);return binb2rstr(binb_sha1(d.concat(g),512+160))}function rstr2hex(c){try{hexcase}catch(g){hexcase=0}var f=hexcase?"0123456789ABCDEF":"0123456789abcdef";var b="";var a;for(var d=0;d<c.length;d++){a=c.charCodeAt(d);b+=f.charAt((a>>>4)&15)+f.charAt(a&15)}return b}function str2rstr_utf8(c){var b="";var d=-1;var a,e;while(++d<c.length){a=c.charCodeAt(d);e=d+1<c.length?c.charCodeAt(d+1):0;if(55296<=a&&a<=56319&&56320<=e&&e<=57343){a=65536+((a&1023)<<10)+(e&1023);d++}if(a<=127){b+=String.fromCharCode(a)}else{if(a<=2047){b+=String.fromCharCode(192|((a>>>6)&31),128|(a&63))}else{if(a<=65535){b+=String.fromCharCode(224|((a>>>12)&15),128|((a>>>6)&63),128|(a&63))}else{if(a<=2097151){b+=String.fromCharCode(240|((a>>>18)&7),128|((a>>>12)&63),128|((a>>>6)&63),128|(a&63))}}}}}return b}function rstr2binb(b){var a=Array(b.length>>2);for(var c=0;c<a.length;c++){a[c]=0}for(var c=0;c<b.length*8;c+=8){a[c>>5]|=(b.charCodeAt(c/8)&255)<<(24-c%32)}return a}function binb2rstr(b){var a="";for(var c=0;c<b.length*32;c+=8){a+=String.fromCharCode((b[c>>5]>>>(24-c%32))&255)}return a}function binb_sha1(v,o){v[o>>5]|=128<<(24-o%32);v[((o+64>>9)<<4)+15]=o;var y=Array(80);var u=1732584193;var s=-271733879;var r=-1732584194;var q=271733878;var p=-1009589776;for(var l=0;l<v.length;l+=16){var n=u;var m=s;var k=r;var h=q;var f=p;for(var g=0;g<80;g++){if(g<16){y[g]=v[l+g]}else{y[g]=bit_rol(y[g-3]^y[g-8]^y[g-14]^y[g-16],1)}var z=safe_add(safe_add(bit_rol(u,5),sha1_ft(g,s,r,q)),safe_add(safe_add(p,y[g]),sha1_kt(g)));p=q;q=r;r=bit_rol(s,30);s=u;u=z}u=safe_add(u,n);s=safe_add(s,m);r=safe_add(r,k);q=safe_add(q,h);p=safe_add(p,f)}return Array(u,s,r,q,p)}function sha1_ft(e,a,g,f){if(e<20){return(a&g)|((~a)&f)}if(e<40){return a^g^f}if(e<60){return(a&g)|(a&f)|(g&f)}return a^g^f}function sha1_kt(a){return(a<20)?1518500249:(a<40)?1859775393:(a<60)?-1894007588:-899497514}function safe_add(a,d){var c=(a&65535)+(d&65535);var b=(a>>16)+(d>>16)+(c>>16);return(b<<16)|(c&65535)}function bit_rol(a,b){return(a<<b)|(a>>>(32-b))};
function md5(a){return rstr2hex(rstr_md5(str2rstr_utf8(a)))}function hex_hmac_md5(a,b){return rstr2hex(rstr_hmac_md5(str2rstr_utf8(a),str2rstr_utf8(b)))}function md5_vm_test(){return md5("abc").toLowerCase()=="900150983cd24fb0d6963f7d28e17f72"}function rstr_md5(a){return binl2rstr(binl_md5(rstr2binl(a),a.length*8))}function rstr_hmac_md5(c,f){var e=rstr2binl(c);if(e.length>16){e=binl_md5(e,c.length*8)}var a=Array(16),d=Array(16);for(var b=0;b<16;b++){a[b]=e[b]^909522486;d[b]=e[b]^1549556828}var g=binl_md5(a.concat(rstr2binl(f)),512+f.length*8);return binl2rstr(binl_md5(d.concat(g),512+128))}function rstr2hex(c){try{hexcase}catch(g){hexcase=0}var f=hexcase?"0123456789ABCDEF":"0123456789abcdef";var b="";var a;for(var d=0;d<c.length;d++){a=c.charCodeAt(d);b+=f.charAt((a>>>4)&15)+f.charAt(a&15)}return b}function str2rstr_utf8(c){var b="";var d=-1;var a,e;while(++d<c.length){a=c.charCodeAt(d);e=d+1<c.length?c.charCodeAt(d+1):0;if(55296<=a&&a<=56319&&56320<=e&&e<=57343){a=65536+((a&1023)<<10)+(e&1023);d++}if(a<=127){b+=String.fromCharCode(a)}else{if(a<=2047){b+=String.fromCharCode(192|((a>>>6)&31),128|(a&63))}else{if(a<=65535){b+=String.fromCharCode(224|((a>>>12)&15),128|((a>>>6)&63),128|(a&63))}else{if(a<=2097151){b+=String.fromCharCode(240|((a>>>18)&7),128|((a>>>12)&63),128|((a>>>6)&63),128|(a&63))}}}}}return b}function rstr2binl(b){var a=Array(b.length>>2);for(var c=0;c<a.length;c++){a[c]=0}for(var c=0;c<b.length*8;c+=8){a[c>>5]|=(b.charCodeAt(c/8)&255)<<(c%32)}return a}function binl2rstr(b){var a="";for(var c=0;c<b.length*32;c+=8){a+=String.fromCharCode((b[c>>5]>>>(c%32))&255)}return a}function binl_md5(p,k){p[k>>5]|=128<<((k)%32);p[(((k+64)>>>9)<<4)+14]=k;var o=1732584193;var n=-271733879;var m=-1732584194;var l=271733878;for(var g=0;g<p.length;g+=16){var j=o;var h=n;var f=m;var e=l;o=md5_ff(o,n,m,l,p[g+0],7,-680876936);l=md5_ff(l,o,n,m,p[g+1],12,-389564586);m=md5_ff(m,l,o,n,p[g+2],17,606105819);n=md5_ff(n,m,l,o,p[g+3],22,-1044525330);o=md5_ff(o,n,m,l,p[g+4],7,-176418897);l=md5_ff(l,o,n,m,p[g+5],12,1200080426);m=md5_ff(m,l,o,n,p[g+6],17,-1473231341);n=md5_ff(n,m,l,o,p[g+7],22,-45705983);o=md5_ff(o,n,m,l,p[g+8],7,1770035416);l=md5_ff(l,o,n,m,p[g+9],12,-1958414417);m=md5_ff(m,l,o,n,p[g+10],17,-42063);n=md5_ff(n,m,l,o,p[g+11],22,-1990404162);o=md5_ff(o,n,m,l,p[g+12],7,1804603682);l=md5_ff(l,o,n,m,p[g+13],12,-40341101);m=md5_ff(m,l,o,n,p[g+14],17,-1502002290);n=md5_ff(n,m,l,o,p[g+15],22,1236535329);o=md5_gg(o,n,m,l,p[g+1],5,-165796510);l=md5_gg(l,o,n,m,p[g+6],9,-1069501632);m=md5_gg(m,l,o,n,p[g+11],14,643717713);n=md5_gg(n,m,l,o,p[g+0],20,-373897302);o=md5_gg(o,n,m,l,p[g+5],5,-701558691);l=md5_gg(l,o,n,m,p[g+10],9,38016083);m=md5_gg(m,l,o,n,p[g+15],14,-660478335);n=md5_gg(n,m,l,o,p[g+4],20,-405537848);o=md5_gg(o,n,m,l,p[g+9],5,568446438);l=md5_gg(l,o,n,m,p[g+14],9,-1019803690);m=md5_gg(m,l,o,n,p[g+3],14,-187363961);n=md5_gg(n,m,l,o,p[g+8],20,1163531501);o=md5_gg(o,n,m,l,p[g+13],5,-1444681467);l=md5_gg(l,o,n,m,p[g+2],9,-51403784);m=md5_gg(m,l,o,n,p[g+7],14,1735328473);n=md5_gg(n,m,l,o,p[g+12],20,-1926607734);o=md5_hh(o,n,m,l,p[g+5],4,-378558);l=md5_hh(l,o,n,m,p[g+8],11,-2022574463);m=md5_hh(m,l,o,n,p[g+11],16,1839030562);n=md5_hh(n,m,l,o,p[g+14],23,-35309556);o=md5_hh(o,n,m,l,p[g+1],4,-1530992060);l=md5_hh(l,o,n,m,p[g+4],11,1272893353);m=md5_hh(m,l,o,n,p[g+7],16,-155497632);n=md5_hh(n,m,l,o,p[g+10],23,-1094730640);o=md5_hh(o,n,m,l,p[g+13],4,681279174);l=md5_hh(l,o,n,m,p[g+0],11,-358537222);m=md5_hh(m,l,o,n,p[g+3],16,-722521979);n=md5_hh(n,m,l,o,p[g+6],23,76029189);o=md5_hh(o,n,m,l,p[g+9],4,-640364487);l=md5_hh(l,o,n,m,p[g+12],11,-421815835);m=md5_hh(m,l,o,n,p[g+15],16,530742520);n=md5_hh(n,m,l,o,p[g+2],23,-995338651);o=md5_ii(o,n,m,l,p[g+0],6,-198630844);l=md5_ii(l,o,n,m,p[g+7],10,1126891415);m=md5_ii(m,l,o,n,p[g+14],15,-1416354905);n=md5_ii(n,m,l,o,p[g+5],21,-57434055);o=md5_ii(o,n,m,l,p[g+12],6,1700485571);l=md5_ii(l,o,n,m,p[g+3],10,-1894986606);m=md5_ii(m,l,o,n,p[g+10],15,-1051523);n=md5_ii(n,m,l,o,p[g+1],21,-2054922799);o=md5_ii(o,n,m,l,p[g+8],6,1873313359);l=md5_ii(l,o,n,m,p[g+15],10,-30611744);m=md5_ii(m,l,o,n,p[g+6],15,-1560198380);n=md5_ii(n,m,l,o,p[g+13],21,1309151649);o=md5_ii(o,n,m,l,p[g+4],6,-145523070);l=md5_ii(l,o,n,m,p[g+11],10,-1120210379);m=md5_ii(m,l,o,n,p[g+2],15,718787259);n=md5_ii(n,m,l,o,p[g+9],21,-343485551);o=safe_add(o,j);n=safe_add(n,h);m=safe_add(m,f);l=safe_add(l,e)}return Array(o,n,m,l)}function md5_cmn(h,e,d,c,g,f){return safe_add(bit_rol(safe_add(safe_add(e,h),safe_add(c,f)),g),d)}function md5_ff(g,f,k,j,e,i,h){return md5_cmn((f&k)|((~f)&j),g,f,e,i,h)}function md5_gg(g,f,k,j,e,i,h){return md5_cmn((f&j)|(k&(~j)),g,f,e,i,h)}function md5_hh(g,f,k,j,e,i,h){return md5_cmn(f^k^j,g,f,e,i,h)}function md5_ii(g,f,k,j,e,i,h){return md5_cmn(k^(f|(~j)),g,f,e,i,h)}function safe_add(a,d){var c=(a&65535)+(d&65535);var b=(a>>16)+(d>>16)+(c>>16);return(b<<16)|(c&65535)}function bit_rol(a,b){return(a<<b)|(a>>>(32-b))};


var crypt = {
	sha1 : sha1,
	md5 : md5
};

var request = {
	param : function(name, def) {
		name = name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
		var regexS = "[\\?&]"+name+"=([^&#]*)";
		var regex = new RegExp( regexS );
		var results = regex.exec( window.location.href );
		if( results == null )
			return def;
		else
			return results[1];
	},
	'platform' : 'XHTML',
	'account' : 'none'
};

var xml = {
	deck : null,
	stack : [],
	savedstacks : {},
	createParser : function(data) {
		var xmlDoc = null;
		try {
			parser=new DOMParser();
			xmlDoc=parser.parseFromString(data, "text/xml");
		} catch(e) {
			try {
				xmlDoc = new ActiveXObject("Microsoft.XMLDOM");
				xmlDoc.async="false";
				xmlDoc.loadXML(data);
			} catch(e) {alert(e.message)}
		}
		return xmlDoc;
	},
	parse : function(data) {
		var deck = xml.createParser(data);
		var tree = {};
		tree[deck.documentElement.nodeName] = xml._parse(deck.documentElement);
		if(deck.documentElement.attributes.length > 0) {
			tree[deck.documentElement.nodeName + '_attr'] = xml._getAttrs(deck.documentElement);
		}
		xml.deck = tree;
	},
	_parse : function(node) {
		var tree = {};
		var repeats = {};
		var repeats_count = {};
		var attributes = {};
		var counts = 0;
		for(var i=0;i<node.childNodes.length;i++) {
			var c = node.childNodes[i];
			var n = c.nodeName
			if(n == '#text')
				continue;
			if(!repeats[n]) {
				repeats[n] = {};
				repeats_count[n] = 0;
				attributes[n] = {};
			} else
				repeats_count[n]++;
			var item = xml._parse(c);
			if(item)
				repeats[n][repeats_count[n]] = item;
			var attrs = xml._getAttrs(c);
			if(attrs)
				attributes[n][repeats_count[n]] = attrs;
			if(item || attrs)
				counts++;
		}
		if(counts == 0)
			return node.innerText ? node.innerText : node.textContent;
		
		for(var i in repeats) {
			if(repeats_count[i] > 0) {
				var mtree = repeats[i];
				if(attributes[i])
					for(var j in attributes[i])
						mtree[j + '_attr'] = attributes[i][j];
				tree[i] = mtree;
			} else {
				if(repeats[i][0])
					tree[i] = repeats[i][0];
				if(attributes[i][0])
					tree[i + '_attr'] = attributes[i][0];
			}
		}
		return tree;
	},
	push : function(path) {
		var split = path.split('/');
		if(xml._gettop())
			xml._push(xml._gettop(), split);
		else
			xml._push(xml.deck, split);
	},
	_push : function(current, pathstack) {
		var c = current;
		var p = 0;
		while(true) {
			if(p == pathstack.length) {
				xml.stack = c;
				return true;
			}
			if(c[pathstack[p]])
				c = c[pathstack[p]];
			else
				return false;
			p++;
		}
	},
	_gettop : function() {
		for(var i in xml.stack)
			return xml.stack[i];
	},
	_getAttrs : function(c) {
		if(c.attributes.length == 0)
			return false;
		var attrs = {};
		for(var j=0;j<c.attributes.length;j++)
			attrs[c.attributes[j].name] = c.attributes[j].value;
		return attrs;
	},
	count : function() {
		var count = 0;
		for(var i in xml.stack) {
			count++;
		}
		return count;
	},
	shift : function() {
		var n = {};
		if(xml.stack.length == 1)
			return true;
		var c = 0;
		for(var i in xml.stack) {
			if(c == 0) {
				c++;
				continue;
			}
			n[c - 1] = xml.stack[i];
			c++;
		}
		xml.stack = n;
	},
	clear : function() {xml.stack = [];},
	save : function(key) {xml.savedstacks[key] = xml.stack;},
	restore : function(key) {xml.stack = xml.savedstacks[key];},
	getvalue : function(key) {
		var x = xml._gettop();
		if(x[key])
			return x[key];
		return '';
	},
	getdeep : function(key) {
		var skey = key.split('/');
		var x = xml._gettop();
		for(var i=0;i<skey.length;i++)
			if(x[skey[i]])
				x = x[skey[i]];
		return x;
	}
};

if(window.google) {
	var cache = {
		get : function(key, callback) {
			var db = google.gears.factory.create('beta.database');
			db.open('appcache');
			db.execute('create table if not exists cache (key text, value int)');
			var rs = db.execute('select value from cache where key = ?', [key]);

			while (rs.isValidRow()) {
				var data = rs.field(0);
				rs.close();
				callback(data);
				return;
			}
			rs.close();
			callback('');
		},
		set : function(key, value) {
			var db = google.gears.factory.create('beta.database');
			db.open('appcache');
			db.execute('create table if not exists cache (key text, value TEXT)');
			db.execute('insert into cache values (?, ?)', [key, value]);
			
		}
	};
	var http = {
		get : function(url) {
			var request = google.gears.factory.create('beta.httprequest');
			request.open('GET', '/proxy.php?url=' + escape(url));
			request.send();
			var x = 0;
			while(request.readyState != 4) {x++;x--;}
			return request.responseText;
		},
		post : function(url, values) {
			var request = google.gears.factory.create('beta.httprequest');
			request.open('POST', '/proxy.php?url=' + escape(url));
			request.send('values=' + escape(values));
			while(request.readyState != 4) {x++;x--;}
			return request.responseText;
		}
	};
} else {
	if(window.localStorage) { // HTML5 Local Storage
		var cache = {
			get : function(key, callback) {
				var data = window.localStorage[key];
				callback(data);
			},
			set : function(key, value) {
				window.localStorage[key] = value;
			}
		};
	} else if(window.openDatabase) { // HTML5 Database
		var cache = {
			db : openDatabase("beta.database", "0.1", "Cache Database"),
			_callback : null,
			get : function(key, callback) {
				cache._callback = callback;
				var database = cache.db;
				if(database) {
					database.transaction(function(tx) {
						tx.executeSql(
							"SELECT value FROM Cache WHERE key = ?",
							[key],
							function(tx, result) {
								if(result.rows.length) {
									var r = result.rows.item(0);
									r = r['value'];
									cache._callback(r);
								} else
									cache._callback('');
							},
							function(tx, error) {
								tx.executeSql("CREATE TABLE IF NOT EXISTS Cache (key TEXT, value TEXT)", [], function(result) {cache._callback('');});
							}
						);
					});
				}
				return '';
			},
			set : function(key, value) {
				var database = cache.db;
				if(database) {
					database.transaction(function(tx) {
						tx.executeSql(
							"INSERT INTO Cache (key, value) VALUES (?, ?)",
							[key, value],
							function(result) {},
							function(tx, error) {
								tx.executeSql("CREATE TABLE IF NOT EXISTS Cache (key TEXT, value TEXT)", [], function(result) {});
							}
						);
					});
				}
			}
		};
	}
	function getNewHTTPObject() {
			var xmlhttp;

			/** Special IE only code ... */
			/*@cc_on
			  @if (@_jscript_version >= 5)
				  try
				  {
					  xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
				  }
				  catch (e)
				  {
					  try
					  {
						  xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
					  }
					  catch (E)
					  {
						  xmlhttp = false;
					  }
				 }
			  @else
				 xmlhttp = false;
			@end @*/

			/** Every other browser on the planet */
			if (!xmlhttp && typeof XMLHttpRequest != 'undefined') {
				try {
					xmlhttp = new XMLHttpRequest();
				} catch (e) {
					xmlhttp = false;
				}
			}

			return xmlhttp;
	}

	var http = {
		get : function(url) {
			var request = getNewHTTPObject();
			request.open('GET', '/proxy.php?url=' + escape(url), false);
			request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
			request.send(null);
			return request.responseText;
		},
		post : function(url, values) {
			var request = getNewHTTPObject();
			request.open('POST', '/proxy.php?url=' + escape(url), false);
			request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
			request.send('values=' + escape(values));
			return request.responseText;
		}
	};
}


