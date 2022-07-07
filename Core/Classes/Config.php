
<?php
class Config {
	public static function Get($Path = null) {
		if($Path) {
			$Config = $GLOBALS["Config"];
			$Path = explode("/", $Path);

			foreach($Path as $Bit) {
				((isset($Config[$Bit])) ? $Config = $Config[$Bit] : null);
			}
			
			return $Config;
		}
		
		return false;
	}
}
?>