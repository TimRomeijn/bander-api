<?php
	require "config.php";
	$return = [];

	$sql = "SELECT * FROM `updates` ORDER BY `id` DESC LIMIT 1";

	$version = [];

	$result = $APIDB->query($sql);
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$version["versionNumber"] = (int) $row["id"];
			$version["time"] = $row["time"];
		}
	} else {
		http_response_code(404); //not found
	}

	$bootNotification = [];

	$sql2 = "SELECT * FROM `boot_notifications` ORDER BY `id` DESC LIMIT 1";
	$result = $APIDB->query($sql2);
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$bootNotification["id"] = (int) $row["id"];
			$bootNotification["message"] = $row["message"];
		}
	} else {
		http_response_code(404); //not found
	}

	$return["version"] = $version;
	$return["bootNotification"] = $bootNotification;

	echo json_encode($return);
?>