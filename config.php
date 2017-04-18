<?php
	//Database configuration
	define("DB_SERVER", "localhost");
	define("DB_NAME", "bander");
	define("DB_USERNAME", "root");
	define("DB_PASSWORD", "");

	require "db.php";
	$APIDB = new APIDB();
	

	//Make the content of the request always in JSON format
	header("Content-Type: application/json");
	header("Access-Control-Allow-Origin: *");
?>