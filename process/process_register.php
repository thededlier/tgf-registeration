<?php
	session_start();

	$flag = "FALSE";		
	$player_id = $name = $team_name = $game1 = $game2 = $fees = "";

	// Get values and test
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$player_id 	= 	test_input($_POST["player_id"]);
		$name 		= 	test_input($_POST["name"]);
		$team_name 	= 	test_input($_POST["team_name"]);
		$game1 		= 	test_input($_POST["game1"]);
		$game2 		= 	test_input($_POST["game2"]);
		$fees		=	test_input($_POST["fees"]);
		$match_status1 = "waiting"; 	// Default value
		$match_status2 = "waiting"; 	// Default value
	}

	function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}

	$servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "tgf";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    echo "Connected successfully";

    $sql = "SELECT player_id FROM register WHERE player_id = '$player_id'";
    $result = $conn->query($sql);

    // [START SUBMISSION]
    // Final check if ID not already used
    if($result->num_rows == 0) {
    	$sql = "INSERT INTO register(player_id, name, team_name, game1, game2, fees_paid, match_status1, match_status2) 
    			VALUES('$player_id', '$name', '$team_name', '$game1', '$game2', '$fees', '$match_status', '$match_status2')";

    	if ($conn->query($sql) === TRUE) {
    		$flag = "TRUE";
	        echo "New record created successfully\n";
	    } else {
	        echo "Error: " . $sql . "<br>" . $conn->error;
	    }
    } else {
    	// ID Already used
    	echo "ID Mismatch";
    }
    // [END SUBMISSION]

    // [START REMOVE_LOCK]
    $sql = "DELETE FROM locks WHERE lock_id = '$player_id'";
    if ($conn->query($sql) === TRUE) {
        echo "Lock removed";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    // [END REMOVE_LOCK]

    // Send back status of registration
    $_SESSION["id_used"] 	=	$player_id;
    $_SESSION["status"] 	=	$flag; 

    header('Location: /register.php');
?>