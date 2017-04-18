<?php
	require "config.php";
	$return = [];

	$sql = "SELECT `exercises`.*, `exercises_has_poi_types`.`poiTypeId`
		FROM `exercises`
		INNER JOIN `exercises_has_poi_types` ON `exercises`.`id` = `exercises_has_poi_types`.`exerciseId`";

	if (isset($_GET["poiTypeId"]) && !empty($_GET["poiTypeId"]) && isset($_GET["difficultyId"]) && !empty($_GET["difficultyId"])) {
		$sql .= " WHERE `exercises_has_poi_types`.`poiTypeId` = " . $_GET["poiTypeId"] . " AND `exercises`.`difficultyId` = " . $_GET["difficultyId"];
	}

	$result = $APIDB->query($sql);
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$tempExercise = [];
			$tempExercise["id"] = (int) $row["id"];
			$tempExercise["poiTypeId"] = (int) $row["poiTypeId"];
			$tempExercise["difficulties"] = getExerciseDifficulties($row["id"]);
			$tempExercise["name"] = $row["name"];
			$tempExercise["description"] = $row["description"];
			$tempExercise["images"] = getExerciseImages($row["id"]);
			array_push($return, $tempExercise);
		}
	} else {
		http_response_code(404); //not found
	}

	// Function that returns an array of images for the given excersize id
	function getExerciseImages($id) {
		global $APIDB;
		$exerciseImagesReturn = [];
		$exerciseImagesResult = $APIDB->query("SELECT * FROM `exercise_images` WHERE `exerciseId` = $id ORDER BY `imageOrder`");
		if ($exerciseImagesResult->num_rows > 0) {
			while($row = $exerciseImagesResult->fetch_assoc()) {
				$tempExerciseImages = [];
				$tempExerciseImages["order"] = (int) $row["imageOrder"];
				$tempExerciseImages["image"] = $row["image"];
				array_push($exerciseImagesReturn, $tempExerciseImages);
			}
		}
		return $exerciseImagesReturn;
	}

	// Function that returns an array of difficulties for the given excersize id
	function getExerciseDifficulties($id) {
		global $APIDB;
		$exerciseDifficultiesReturn = [];
		$exerciseDifficultiesResult = $APIDB->query("SELECT * FROM `exercise_has_difficulties` WHERE `exerciseId` = $id ORDER BY `difficultyId`");
		if ($exerciseImagesResult->num_rows > 0) {
			while($row = $exerciseImagesResult->fetch_assoc()) {
				$tempExerciseDifficulties = [];
				$tempExerciseDifficulties["exerciseId"] = (int) $row["exerciseId"];
				$tempExerciseDifficulties["difficultyId"] = (int) $row["difficultyId"];
				$tempExerciseDifficulties["times"] = (int) $row["times"];
				$tempExerciseDifficulties["description"] = $row["description"];
				array_push($exerciseDifficultiesReturn, $tempExerciseDifficulties);
			}
		}
		return $exerciseDifficultiesReturn;
	}

	echo json_encode($return);
?>