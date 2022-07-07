<?php
class Logger {
    private static function BreakError(string $ErrorMessage = null) {
        $ErrorBits = explode("Stack", $ErrorMessage);
        $Date = StringFormatter::GetDateTime();

        $ErrorData = array(
            "basic" => "{$Date} " . str_replace("PDOException:", "", explode("in", $ErrorBits[0])[0]) . "\n\n",
            "class" => "{$Date} Class: " . $ErrorBits[0] . "\n\n",
            "stack" => "{$Date} Stack" . str_replace("#", "#", $ErrorBits[1]) . "\n\n",
            "full" => "{$Date} {$ErrorMessage}\n\n",
        );

        $Responder = strtolower(Config::Get("AppData/ErrorResponder"));

        return ($Responder === "basic") ? $ErrorData["basic"] : (($Responder === "class") ? $ErrorData["class"] : (($Responder === "stack") ? $ErrorData["stack"] : $ErrorData["full"]));
    }

    public static function Error(string $ErrorTag = null, string $ErrorMessage = null) {
        $Tag = (($ErrorTag !== null) ? $ErrorTag : null);
        $ErrorMessage = (($ErrorMessage !== null) ? $ErrorMessage : null);

        if($Tag !== null) {
            switch(strtolower($Tag)) {
                /* Database Error Tags */
                case "database-connect":
                    $Error = (($ErrorMessage !== null) ? self::BreakError($ErrorMessage) : "Failed to connect to the database");
                    break;
                case "database-insert":
                    $Error = (($ErrorMessage !== null) ? self::BreakError($ErrorMessage) : "Failed to insert data into the database");
                    break;
                case "database-select":
                    $Error = (($ErrorMessage !== null) ? self::BreakError($ErrorMessage) : "Failed to select database data");
                    break;

                /* Location Error Tags */
                case "get-location":
                    $Error = (($ErrorMessage !== null) ? self::BreakError($ErrorMessage) : "Failed to get client location");
                    break;

                default:
                    $Error = "Undefined Error Type: {$Tag}";
                    break;
            }

            $Responder = strtolower(Config::Get("AppData/ErrorResponder"));
            $FileName = ($Responder === "basic") ? "BasicLog" : (($Responder === "class") ? "ClassLog" : (($Responder === "stack") ? "StackLog" : "FullLog"));
            file_put_contents("Logs/Error.{$FileName}", $Error, FILE_APPEND | LOCK_EX);

            Redirect::To(Config::Get("PassThrough/Redirect"));
        }
    }
}
?>