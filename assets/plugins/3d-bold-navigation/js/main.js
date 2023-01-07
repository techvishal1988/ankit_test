jQuery(document).ready(function($){
	function toggleNav(bool) {
		$('.cd-nav-container, .cd-overlay').toggleClass('is-visible', bool);
		$('main').toggleClass('scale-down', bool);
		$('body').toggleClass('navigation-visible', bool);
	}
    
	//open navigation clicking the menu icon
	$('.cd-nav-trigger').on('click', function(event){
		event.preventDefault();
		toggleNav(true);
	});
    
	//close the navigation
	$('.cd-close-nav, .cd-overlay').on('click', function(event){
		event.preventDefault();
		toggleNav(false);
	});

});


//Function To check date format is valid (dd/mm/yyyy) or not
function checkDateFormat(that) 
{
	var mo, day, yr;
	var entry = that.value;
	var re = /\b\d{1,2}[\/-]\d{1,2}[\/-]\d{4}\b/;

	if(re.test(entry)) 
	{
		var delimChar = (entry.indexOf("/") != -1) ? "/" : "-";
		var delim1 = entry.indexOf(delimChar);
		var delim2 = entry.lastIndexOf(delimChar);
		day = parseInt(entry.substring(0, delim1), 10);
		mo = parseInt(entry.substring(delim1 + 1, delim2), 10);
		yr = parseInt(entry.substring(delim2 + 1), 10);
		var testDate = new Date(yr, mo - 1, day);
		if (testDate.getDate() == day) {
			if (testDate.getMonth() + 1 == mo) {
				if (testDate.getFullYear() == yr) {
					return true;
				} else {
					that.value = "";
					}
			}
			else {
				that.value = "";
			}
		}
		else {
			that.value = "";
		}
	}
	else 
	{
		if (entry != "") 
		{
			that.value = "";
		}
	}
	return false;
}