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
			"/chrome/i"    => "Chrome",
			"/edge/i"      => "Edge",
			"/opera/i"     => "Opera",
			"/netscape/i"  => "Netscape",
			"/maxthon/i"   => "Maxthon",
			"/konqueror/i" => "Konqueror",
			"/mobile/i"    => "Handheld Browser",
            "/safari/i"    => "Safari",
		);
			
		foreach ($BrowserArray as $Regex => $Browser) {
            if(preg_match($Regex, $UserAgent)) {
                return $Browser;
            }
		}

		return null;
	}

    public static function HasLocationKey(string $LocationKey = null, array $Location = null, bool $Nullify = false) {
        return (($LocationKey !== null && $Location !== null) && (is_array($Location) && count($Location) > 0) && array_key_exists(lowercase($LocationKey), $Location) ? $Location[lowercase($LocationKey)]: (($Nullify === true) ? null : "Unknown"));
    }

    public static function GetLocation(string $IPAddress = null) {
        $APIKey = ((!empty(Config::Get("AppData/API/IPInfo")) && Validate::IPInfoAPIKey(Config::Get("AppData/API/IPInfo"))) ? Config::Get("AppData/API/IPInfo") : null);
        $Json = (($APIKey !== null) ? (($IPAddress !== null && Validate::IPAddress($IPAddress) === true) ? file_get_contents("http://ipinfo.io/{$IPAddress}?token={$APIKey}") : false) : false);
        $Location = (($Json !== false) ? json_decode($Json, true) : null);

        if($Location !== null) {
            return array(
                "ip_address" => $IPAddress,
                "city" => self::HasLocationKey("city", $Location),
                "region" => self::HasLocationKey("region", $Location),
                "country" => self::HasLocationKey("country", $Location),
                "latitude" => ((array_key_exists("loc", $Location)) ? explode(",", $Location["loc"])[0] : "Unknown"),
                "longitude" => ((array_key_exists("loc", $Location)) ? explode(",", $Location["loc"])[1] : "Unknown"),
                "full_location" => StringFormatter::BuildFullLocationString(self::HasLocationKey("city", $Location, true), self::HasLocationKey("region", $Location, true), self::HasLocationKey("country", $Location, true)),
                "service_provider" => self::HasLocationKey("org", $Location),
                "timezone" => self::HasLocationKey("timezone", $Location),
            );
        } else {
            Logger::Error("get-location");
        }

        return null;
    }
}
?>
