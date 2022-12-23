<?php
class StringFormatter {
    public static function GetDateTime(bool $IncludeSeconds = true, bool $AmOrPm = false): string {
        return date("Y-m-d H:i" . (($IncludeSeconds === true) ? ":s" : "") .  (($AmOrPm === true) ? "a" : ""));
    }

    public static function GetDate(): string {
        return date("Y-m-d");
    }

    public static function GetTime(bool $AmOrPm = false): string {
        return ($AmOrPm) ? strtolower(date("H:i:s A")) : date("H:i:s");
    }
    
    public static function BuildFullLocationString(string $City = null, string $Region = null, string $Country = null): string {
        $FullLocationString = null;

        if($City !== null) {
            $FullLocationString = "{$City}";
        } else {
            $FullLocationString = "Unknown City";
        }

        if($Region !== null) {
            $FullLocationString .= ", {$Region}";
        } else {
            $FullLocationString .= ", Unknown Region";
        }

        if($Country !== null) {
            $FullLocationString .= ", {$Country}";
        } else {
            $FullLocationString .= ", Unknown Country";
        }
        
        return $FullLocationString;
    }
}
?>
