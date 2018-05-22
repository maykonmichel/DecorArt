$(document).ready(function() {
    var url = window.location.search.replace("?", "");
	activateTab(url);
});

function activateTab(pageId) {
	var tabs = Array("signup", "login");
	if(pageId != tabs[0] && pageId != tabs[1]) {
		tabs = Array("user", "product", "statistic");
	}
	for(var k = 0; k < 4; k++) {
		document.getElementById(tabs[k]).style.display = (tabs[k] == pageId) ? 'block' : 'none';
		document.getElementById("tab-"+tabs[k]).style.backgroundColor = (tabs[k] == pageId) ? '#0000BB' : '#7575FF';
	}
}