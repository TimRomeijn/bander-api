<?php
	require "config.php";
	$return = [];

	$sql = "SELECT * FROM `poi_types`";

	if (isset($_GET["id"]) && !empty($_GET["id"])) {
		$sql .= " WHERE `id` = " . $_GET["id"];
	}

	$result = $APIDB->query($sql);
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$tempPOIType = [];
			$tempPOIType["id"] = (int) $row["id"];
			$tempPOIType["name"] = $row["name"];
			$tempPOIType["icon"] = $row["icon"];
			$tempPOIType["icon"] = $row["color"];
			array_push($return, $tempPOIType);
		}
	} else {
		http_response_code(404); //not found
	}

	echo json_encode($return);
?>