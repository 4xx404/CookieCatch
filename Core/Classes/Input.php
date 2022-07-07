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
		return ((isset($_POST[$Item])) ? $_POST[$Item] : ((isset($_GET[$Item])) ? $_GET[$Item] : ""));
	}
}