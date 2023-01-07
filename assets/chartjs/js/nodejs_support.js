var NodeJs_API_Helper = function(t) {
	this.token=t;
};
if(window.location.host!='localhost'){
NodeJs_API_Helper.prototype.base_url = window.location.protocol +'//'+ window.location.host +"/api/v1" ;//"https://alpha.compport.com/api/v1";
}
else
{
NodeJs_API_Helper.prototype.base_url = "http://localhost:3000"; 
}
console.log(NodeJs_API_Helper.prototype.base_url );

NodeJs_API_Helper.prototype.cookie_name = "Acc3ssTo73n";

NodeJs_API_Helper.prototype.getAjaxCommonSettings = function(url){
	var settings = {
			"async": true,
			"crossDomain": true,
			"headers": { 'Auth': this.token },
			"method": "GET",
			"url": url
	};
	return settings;
};

NodeJs_API_Helper.prototype.isEmpty = function(data) {
    for(var key in data) {
        if(data.hasOwnProperty(key))
            return false;
    }
    return true;
};

NodeJs_API_Helper.prototype.getCookie = function(){
	return this.token;
	var name = this.cookie_name + "=";
	var ca = document.cookie.split(';');
	for(var i = 0; i < ca.length; i++) {
		var c = ca[i];
		while (c.charAt(0) == ' ') {
			c = c.substring(1);
		}
		if (c.indexOf(name) == 0) {
			return c.substring(name.length, c.length);
		}
	}
	return "";
};
