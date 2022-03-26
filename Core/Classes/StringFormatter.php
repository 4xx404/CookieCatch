<?php
class StringFormatter {
    public static function GetDateTime() {
        return date("Y-m-d H:i:s");   
    }

    public static function GetDate() {
        return date("Y-m-d");
    }

    public static function GetTime($AmOrPm = false) {
        return ($AmOrPm) ? strtolower(date("H:i:s A")) : date("H:i:s");
    }
    
    public static function BuildFullLocationString(string $City = null, string $Region = null, string $Country = null) {
        $FullLocationString = "";

        $FullLocationString .= ($City !== null) ? (($Region !== null) ? (($Country !== null) ? escape(ucwords(strtolower($City))) . ", " . escape(ucwords(strtolower($Region))) . ", " . escape(ucwords(strtolower($Country))) : escape(ucwords(strtolower($City))) . ", " . escape(ucwords(strtolower($Region)))) : escape(ucwords(strtolower($City)))) : "Unknown Location";

        return $FullLocationString;
    }
}
?>