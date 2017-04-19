<?php
	require "config.php";
	$return = [];

	$sql = "SELECT * FROM `bndr_profile`";

	if (isset($_GET["id"]) && !empty($_GET["id"])) {
		$sql .= " WHERE `id` = " . $_GET["id"];
	}

	$result = $APIDB->query($sql);
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$tempDifficulty = [];
			$tempDifficulty["id"] = (int) $row["id"];
			$tempDifficulty["name"] = $row["name"];
			$tempDifficulty["image"] = $row["image"];
			$tempDifficulty["email_adress"] = $row["email_adress"];
			$tempDifficulty["tel_number"] = (int) $row["tel_number"];
			$return = $tempDifficulty;
		}
	} else {
		http_response_code(404); //not found
	}

	echo json_encode($return);
?>