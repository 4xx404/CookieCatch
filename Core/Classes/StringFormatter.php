<?php
class StringFormatter {
    public static function GetDateTime(): string {
        return date("Y-m-d H:i:s");
    }

    public static function GetDate(): string {
        return date("Y-m-d");
    }

    public static function GetTime(bool $AmOrPm = false): string {
        return ($AmOrPm) ? strtolower(date("H:i:s A")) : date("H:i:s");
    }
    
    public static function BuildFullLocationString(string $City = null, string $Region = null, string $Country = null): string {
        $FullLocationString = null;

        ($City !== null) ? $FullLocationString = $City . ", " : $FullLocationString = "Unknown City, ";
        ($Region !== null) ? $FullLocationString .= $Region . ", " : $FullLocationString .= "Unknown Region, ";
        ($Country !== null) ? $FullLocationString .= $Country . ", " : $FullLocationString .= "Unknown Country";

        return $FullLocationString;
    }
}
?>
