<?php
class HTMLBuilder {
    public static function GetDoctypeAndLang() {
        return "
            <!DOCTYPE html>
            <html lang=\"" . escape(substr($_SERVER["HTTP_ACCEPT_LANGUAGE"], 0, 2)) . "\">
        ";
    }

    /* Css & JavaScript follow the same path format so this function can be used for both */
    /* This functions AllowedFiles are page specific so again match both Css & Javascript */
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

    public static function GetHead(string $Title = null, string $LandingPage = null) {
        return "
            <head>
                <title>" . (($Title !== null) ? escape(ucwords(strtolower($Title))) : escape(Config::Get("AppData/Name"))) . "</title>
                <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
                <script type=\"text/javascript\" src=\"" . Config::Get("AssetURLs/JQuery") . "\"></script>
                <link rel=\"stylesheet\" href=\"" . Config::Get("AssetURLs/FontAwesome") . "\" />
                <link rel=\"stylesheet\" type=\"text/css\" href=\"Css/Generic.css\" />
                <script src=\"JavaScript/Generic.js\"></script>
                " . (($LandingPage !== null) ? self::GetImportable("both", $LandingPage) : "") . "
            </head>
            <body>
        ";       
    }

    public static function GetHeader() {
        return "
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

    public static function GetFooter() {
        return "
                <div class=\"footer\" id=\"footer\">
        	        <h6 class=\"footer-text\" id=\"footer-text\">" . escape(Config::Get("AppData/Name")) . " " . escape(Config::Get("AppData/Version")) . "</h6>
                </div>
            </body>
            </html>
        ";
    }
}
?>
