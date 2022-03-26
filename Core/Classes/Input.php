<?php
class Input {
	const FORM_SUBMISSION_TYPE = "form-submission-type";

	public static function Exists($Type = "post") {
		switch(strtolower($Type)) {
			case "post":
				return (!empty($_POST)) ? true : false;
				break;
			case "get":
				return (!empty($_GET)) ? true : false;
				break;

			default:
				return false;
				break;
		}
	}
	
	public static function Get($Item) {
		if(isset($_POST[$Item])) {
			return $_POST[$Item];
		} else if(isset($_GET[$Item])) {
			return $_GET[$Item];
		}

		return "";
	}
}