<?php
class Redirect {
	public static function To($Location = null) {
		if($Location) {
			if(is_numeric($Location)) {
				switch($Location) {
					case "404":
						header("HTTP/1.0 404 Not Found");
						include("Includes/Errors/404.php");
						exit();
					break;
				}
			}

			header("Location: {$Location}");
			exit();
		}
	}	
}