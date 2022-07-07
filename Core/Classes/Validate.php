<?php
class Validate {
	public static function IPAddress(string $IPAddress = null): bool {
        return (($IPAddress !== null && filter_var($IPAddress, FILTER_VALIDATE_IP) !== false) ? true : false);
    }

    public static function IPInfoAPIKey(string $APIKey = null): bool {
        return (($APIKey !== null && (is_string($APIKey) && strlen($APIKey) === 14)) ? true : false);
    }
}