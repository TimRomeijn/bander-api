<?php
require 'config.php';
require "checkCredentials.php";
$db = new checkCredentials();

// json response array
$response = array("error" => FALSE);

if (isset($_POST['name']) && isset($_POST['password'])
 && isset($_POST['image']) && isset($_POST['lat']) && isset($_POST['lng'])
  && isset($_POST['email_adress']) && isset($_POST['tel_number'])) {

    // receiving the post params
    $name = $_POST['name'];
    $password = $_POST['password'];
    $image = $_POST['image'];
    $lat = $_POST['lat'];
    $lng = $_POST['lng'];
    $email_adress = $_POST['email_adress'];
    $tel_number = $_POST['tel_number'];

    // check if user is already existed with the same name
    if ($db->isUserExisted($name)) {
        // user already existed
        $response["error"] = TRUE;
        $response["error_msg"] = "User already existed with name " . $name;
        echo json_encode($response);
    } 
    else {
        // create a new user
        $profile = $db->storeProfile($name, $password, $image, $lat, $lng, $email_adress, $tel_number);
        if ($profile) {
            // user stored successfully
            $response["error"] = FALSE;
            $response["user"]["name"] = $profile["name"];
            echo json_encode($response);
        } 
        else {
            // user failed to store
            $response["error"] = TRUE;
            $response["error_msg"] = "Unknown error occurred in registration!";
            echo json_encode($response);
        }
    }
}
 else {
    $response["error"] = TRUE;
    $response["error_msg"] = "Required parameters (name, email or password) is missing!";
    echo json_encode($response);
}
?>

