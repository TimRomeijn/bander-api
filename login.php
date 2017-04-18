<?php
require 'config.php';
require "checkCredentials.php";
$db = new checkCredentials();

// json response array
$response = array("error" => FALSE);

if (isset($_POST['name']) && isset($_POST['password'])) {

    // receiving the post params
    $name = $_POST['name'];
    $password = $_POST['password'];

    // get the user by email and password
    $profile = $db->getUserByNameAndPassword($name, $password);

    if ($profile) {
        // user is found
        $response["error"] = FALSE;
        $response["message"] = "Succesfully logged in, welcome " . $profile["name"];
        // $response["uid"] = $profile["unique_id"];
        // $response["profile"]["name"] = $profile["name"];
        // $response["profile"]["email_adress"] = $profile["email_adress"];
        // $response["profile"]["password"] = $profile["password"];
        // $response["profile"]["image"] = $profile["image"];
        // $response["profile"]["audio_id"] = $profile["audio_id"];
		// $response["profile"]["lat"] = $profile["lat"];
        // $response["profile"]["lng"] = $profile["lng"];
        // $response["profile"]["tel_number"] = $profile["tel_number"];


        echo json_encode($response);
    } else {
        // user is not found with the credentials
        $response["error"] = TRUE;
        $response["error_msg"] = "Login credentials are wrong. Please try again!";
        echo json_encode($response);
    }
} else {
    // required post params is missing
    $response["error"] = TRUE;
    $response["error_msg"] = "Required parameters email or password is missing!";
    echo json_encode($response);
}
?>

