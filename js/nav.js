$(document).ready(function() {
	// Nav selection
	var url = (window.location.href).split('/');
	var page = (url[url.length-1]).split('.')[0];
	if (page) {
		$('#'+page).addClass('selected');
		$('#'+page).attr('href','');
	}
  else {  // root = world outreach
    $('#index').addClass('selected');
  }
})