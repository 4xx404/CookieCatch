<?php
class Validate {
	public static function PasswordsMatch(string $Password = null, string $ConfirmPassword = null) {
		return (($Password !== null && $ConfirmPassword !== null) && ($Password === $ConfirmPassword)) ? true : false;
	}

	public static function AllowedMediaType(string $MediaType = null) {
		return ($MediaType !== null && (strtolower($MediaType) === "image" || strtolower($MediaType) === "video")) ? true : false;
	}

	public static function HasCSRFProtection(string $FormCsrfToken = null, string $RedirectTo = null) {
		return ($FormCsrfToken !== null && $RedirectTo !== null) ? ((Session::Get("csrf") === $FormCsrfToken) ? Session::Delete("csrf") : $RedirectTo) : $RedirectTo;
	}

	public static function HasSession() {
		return (Session::Exists("access") !== false) ? null : Redirect::To("index.php");
	}

	public static function HasLogout(string $FormSubmissionType = null) {
		return ($FormSubmissionType !== null && escape(strtolower($FormSubmissionType)) !== "logout") ? escape(strtolower($FormSubmissionType)) : User::Logout();
	}
}