<?php
	require "config.php";
	$return = [];

	$sql = "SELECT * FROM `pois`";

	if (isset($_GET["routeId"]) && !empty($_GET["routeId"])) {
		$sql .= " WHERE `routeId` = " . $_GET["routeId"];
	}

	$result = $APIDB->query($sql);
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$tempPOIs = [];
			$tempPOIs["id"] = (int) $row["id"];
			$tempPOIs["name"] = $row["name"];
			$tempPOIs["routeId"] = (int) $row["routeId"];
			$tempPOIs["poiTypeId"] = (int) $row["poiTypeId"];
			$tempPOIs["lat"] = (float) $row["lat"];
			$tempPOIs["lon"] = (float) $row["lon"];
			array_push($return, $tempPOIs);
		}
	} else {
		http_response_code(404); //not found
	}

	echo json_encode($return);
?>