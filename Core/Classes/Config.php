
<?php
class Config {
	public static function Get($Path = null) {
		if($Path) {
			$Config = $GLOBALS["Config"];
			$Path = explode("/", $Path);

			foreach($Path as $Bit) {
				if(isset($Config[$Bit])) {
					$Config = $Config[$Bit];
				}
			}
			
			return $Config;
		}
		
		return false;
	}
}
?>