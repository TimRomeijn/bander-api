<?php
	//Database configuration
	error_reporting(E_ERROR | E_WARNING | E_PARSE);
	define("DB_SERVER", "sql.hosted.hr.nl");
	define("DB_NAME", "0894594");
	define("DB_USERNAME", "0894594");
	define("DB_PASSWORD", "57da9b39");

	require "db.php";
	$APIDB = new APIDB();
	

	//Make the content of the request always in JSON format
	header("Content-Type: application/json");
	header("Access-Control-Allow-Origin: *");
?>