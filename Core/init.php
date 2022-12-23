<?php
$GLOBALS["Config"] = array(
    "AppData" => array(
		"Name" => "CookieCatch",
        "Version" => "2.0",

		/* 
		 * API Key used to get Client location information via IPInfo
		 * You can get an API key for free by signing up for an account
		 * at https://ipinfo.io/ (Free Account: 50,000 requests per month)
		*/
		"API" => array(
			"IPInfo" => "",
		),

		/* 
		 * Error Responder defines the amount of detail reported in error logs
		 * Log File: /CookieCatch/Logs/Error.log
		 * 
		 * Responder Types:
		 * 		basic
		 * 		class
		 * 		stack
		 * 		full (DEFAULT)
		*/
		"ErrorResponder" => "full"
    ),

	"Database" => array(
		"SQLite" => "Core/Database/CookieCatch.db",
	),

	"PassThrough" => array(
		"Redirect" => "https://www.google.com/"
	),

	"Functions" => array(
		"Strings",
	),
);

spl_autoload_register(function ($Class) {
	require_once("Classes/" . ucfirst($Class) . ".php");
});

foreach($GLOBALS["Config"]["Functions"] as $Function) {
	require_once("Functions/" . ucfirst($Function) . ".php");
}
