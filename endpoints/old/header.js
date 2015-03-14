function cache() {}
cache.get = function(key, callback) {callback(back_cache.get(key))};
cache.set = function(key, value) {back_cache.set(key, value);};