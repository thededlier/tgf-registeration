<?php
	session_start();
	$id_unlock 	= $_POST["lock_id"];
	
	$servername = "localhost";
    $username 	= "root";
    $password 	= "";
    $dbname 	= "tgf";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    echo "Connected successfully";

    // Unlock mechanism : if unlcoked from registration page must also unlock currently loaded ID so as to not go into an unlock loop
    // [START UNLOCK]
    $sql = "DELETE FROM locks where lock_id = '$id_unlock'";
 	if ($conn->query($sql)) {
 		$_SESSION["id_unlock"] = $id_unlock;
 		header("Location: /locks.php");
 	} else {
 		echo "Failed to unlcok ID " . $id_unlock;
 	}
 	// [STOP UNLOCK]
?>