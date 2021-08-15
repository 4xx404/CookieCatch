function getCookie(){
        var decodedCookie = decodeURIComponent(document.cookie);
	var dc = decodedCookie;
	document.getElementById('cookieval').value = document.cookie;
	document.getElementById('decodedcookie').value = dc;
	document.getElementById('submitForm').click();		
	
}
