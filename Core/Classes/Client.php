<?php
class Client {
    public static function GetIP() {
        if (isset($_SERVER["HTTP_CLIENT_IP"])) {
            return $_SERVER["HTTP_CLIENT_IP"];
        } else if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
            return $_SERVER["HTTP_X_FORWARDED_FOR"];
        } else if (isset($_SERVER["HTTP_X_FORWARDED"])) {
            return $_SERVER["HTTP_X_FORWARDED"];
        } else if (isset($_SERVER["HTTP_FORWARDED_FOR"])) {
            return $_SERVER["HTTP_FORWARDED_FOR"];
        } else if (isset($_SERVER["HTTP_FORWARDED"])) {
            return $_SERVER["HTTP_FORWARDED"];
        } else if (isset($_SERVER["REMOTE_ADDR"])) {
           return $_SERVER["REMOTE_ADDR"];
        }
        
        return null;
    }

    public static function GetUserAgent() {
        return (isset($_SERVER["HTTP_USER_AGENT"])) ? escape($_SERVER["HTTP_USER_AGENT"]) : null;
    }

    public static function GetOS($UserAgent){
		$OSArray = array(
			"/windows nt 10/i"      =>  "Windows 10",
			"/windows nt 6.3/i"     =>  "Windows 8.1",
			"/windows nt 6.2/i"     =>  "Windows 8",
			"/windows nt 6.1/i"     =>  "Windows 7",
			"/windows nt 6.0/i"     =>  "Windows Vista",
			"/windows nt 5.2/i"     =>  "Windows Server 2003/XP x64",
			"/windows nt 5.1/i"     =>  "Windows XP",
			"/windows xp/i"         =>  "Windows XP",
			"/windows nt 5.0/i"     =>  "Windows 2000",
			"/windows me/i"         =>  "Windows ME",
			"/win98/i"              =>  "Windows 98",
			"/win95/i"              =>  "Windows 95",
			"/win16/i"              =>  "Windows 3.11",
			"/macintosh|mac os x/i" =>  "Mac OS X",
			"/mac_powerpc/i"        =>  "Mac OS 9",
			"/linux/i"              =>  "Linux",
			"/ubuntu/i"             =>  "Ubuntu",
			"/iphone/i"             =>  "iPhone",
			"/ipod/i"               =>  "iPod",
			"/ipad/i"               =>  "iPad",
			"/android/i"            =>  "Android",
			"/blackberry/i"         =>  "BlackBerry",
			"/webos/i"              =>  "Mobile"
		);

		foreach ($OSArray as $Regex => $Platform) {
			if(preg_match($Regex, $UserAgent)) {
				return $Platform;
			}
		}

		return null;
	}

    public static function GetBrowser($UserAgent) {
		$BrowserArray = array(
			"/msie/i"      => "Internet Explorer",
			"/firefox/i"   => "Firefox",
			"/safari/i"    => "Safari",
			"/chrome/i"    => "Chrome",
			"/edge/i"      => "Edge",
			"/opera/i"     => "Opera",
			"/netscape/i"  => "Netscape",
			"/maxthon/i"   => "Maxthon",
			"/konqueror/i" => "Konqueror",
			"/mobile/i"    => "Handheld Browser"
		);
			
		foreach ($BrowserArray as $Regex => $Browser) {
            if(preg_match($Regex, $UserAgent)) {
                return $Browser;
            }
		}

		return null;
	}

    public static function GetLocation(string $IPAddress = null) {
        if($IPAddress !== null) {
            try {
                $Json = file_get_contents("http://ipinfo.io/" . $IPAddress . "?token=" . Config::Get("AppData/API/IPInfo"));
                $Location = json_decode($Json, true);
                if(array_key_exists("timezone", $Location)) {
                    return array(
                        "ip_address" => $IPAddress,
                        "city" => ($Location["city"] !== null) ? $Location["city"] : "Unknown",
                        "region" => ($Location["region"] !== null) ? strtolower($Location["region"]) : "Unknown",
                        "country" => ($Location["country"] !== null) ? strtolower($Location["country"]) : "Unknown",
                        "latitude" => ($Location["loc"] !== null) ? explode(",", $Location["loc"])[0] : "Unknown",
                        "longitude" => ($Location["loc"] !== null) ? explode(",", $Location["loc"])[1] : "Unknown",
                        "full_location" => StringFormatter::BuildFullLocationString($Location["city"], $Location["region"], $Location["country"]),
                        "service_provider" => ($Location["org"] !== null) ? $Location["org"] : "Unknown",
                        "timezone" => ($Location["timezone"] !== null) ? $Location["timezone"] : "Unknown"
                    );
                }
            } catch(Exception $e) {
                Logger::Error("get-location", $e);
            }
        }

        return null;
    }
}
?>
