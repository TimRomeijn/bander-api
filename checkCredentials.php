<?php

class checkCredentials {
 private $APIDB;
 public function __construct() {
    global $APIDB;
    $this->APIDB = $APIDB;
 }

 public function storeProfile($name, $password, $image, $lat, $lng, $email_adress, $tel_number) {
        // $uuid = uniqid('', true);
        $hash = $this->hashSSHA($password);
        $encrypted_password = $hash["encrypted"]; // encrypted password
        $salt = $hash["salt"]; // salt
        $stmt = "";
        $stmt = $this->APIDB->conn->prepare("INSERT INTO bndr_profile(name, password, salt, image, lat, lng, email_adress, tel_number) VALUES(?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssss", $name, $encrypted_password, $salt, $image, $lat, $lng, $email_adress, $tel_number);
        $result = $stmt->execute();
        $stmt->close();


        // check for successful store
        if ($result) 
		{
			$user = null;
            $stmt = $this->APIDB->conn->prepare("SELECT name, password, salt, image, lat, lng, email_adress, tel_number FROM bndr_profile WHERE name = ?");
			$stmt->bind_param("s", $name);
			$result = $stmt->execute();
			$stmt->bind_result($name, $password, $salt, $image, $lat, $lng, $email_adress, $tel_number);
			while($stmt->fetch())
			{
				$user["name"] = $name;
			}
			
			$stmt->close();
	
			return $user;
        } 
		else {
            return false;
        }
    }
    /**
     * Get user by name and password
     */
    public function getUserByNameAndPassword($name, $password2) {
        $stmt = $this->APIDB->conn->prepare("SELECT  name, password, salt FROM bndr_profile WHERE name = ?");
        $stmt->bind_param("s", $name);
        if ($stmt->execute()) {
			
			$stmt->bind_result($name, $password, $salt);
			
			while($stmt->fetch())
			{
				$user["name"] = $name;
			}
			
			$stmt->close();
            // verifying user password
            $encrypted_password = $password;
            $hash = $this->checkhashSSHA($salt, $password2);
            // check for password equality
            if ($encrypted_password == $hash) {
                // user authentication details are correct
                return $user;
            }
        } else {
            return NULL;
        }
    }
    /**
     * Check user is existed or not
     */
    public function isUserExisted($name) {
        $stmt = $this->APIDB->conn->prepare("SELECT name from bndr_profile WHERE name = ?");
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            // user existed 
            $stmt->close();
            return true;
        } else {
            // user not existed
            $stmt->close();
            return false;
        }
    }
    /**
     * Encrypting password
     * @param password
     * returns salt and encrypted password
     */
    public function hashSSHA($password) {
        $salt = sha1(rand());
        $salt = substr($salt, 0, 10);
        $encrypted = base64_encode(sha1($password . $salt, true) . $salt);
        $hash = array("salt" => $salt, "encrypted" => $encrypted);
        return $hash;
    }
    /**
     * Decrypting password
     * @param salt, password
     * returns hash string
     */
    public function checkhashSSHA($salt, $password) {
        $hash = base64_encode(sha1($password . $salt, true) . $salt);
        return $hash;
    }
}


?>