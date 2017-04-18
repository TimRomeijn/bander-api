<?php
	require "config.php";
	$return = [];

	$sql = "SELECT * FROM `routes`";

	if (isset($_GET["id"]) && !empty($_GET["id"])) {
		$sql .= " WHERE `id` = " . $_GET["id"];
	}

	$result = $APIDB->query($sql);
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$tempRoute = [];
			$tempRoute["id"] = (int) $row["id"];
			$tempRoute["name"] = $row["name"];
			$tempRoute["description"] = $row["description"];
			$tempRoute["waypoints"] = getRouteWaypoints($row["id"]);
			$tempRoute["color"] = $row["color"];
			$tempRoute["images"] = getRouteImages($row["id"]);
			array_push($return, $tempRoute);
		}
	} else {
		http_response_code(404); //not found
	}

	// Function that returns an array of waypoints for the given route id
	function getRouteWaypoints($id) {
		global $APIDB;
		$routeWaypointsReturn = [];
		$routeWaypointsResult = $APIDB->query("SELECT * FROM `route_waypoints` WHERE `routeId` = $id");
		if ($routeWaypointsResult->num_rows > 0) {
			while($row = $routeWaypointsResult->fetch_assoc()) {
				$tempRouteWaypoints = [];
				$tempRouteWaypoints["lat"] = (float) $row["lat"];
				$tempRouteWaypoints["lon"] = (float) $row["lon"];
				array_push($routeWaypointsReturn, $tempRouteWaypoints);
			}
		}
		return $routeWaypointsReturn;
	}

	// Function that returns an array of images for the given route id
	function getRouteImages($id) {
		global $APIDB;
		$routeImagesReturn = [];
		$routeImagesResult = $APIDB->query("SELECT * FROM `route_images` WHERE `routeId` = $id");
		if ($routeImagesResult->num_rows > 0) {
			while($row = $routeImagesResult->fetch_assoc()) {
				array_push($routeImagesReturn, $row["image"]);
			}
		}
		return $routeImagesReturn;
	}

	echo json_encode($return);
?>