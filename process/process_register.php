<?php
	// define variables and set to empty values
	$player_id = $name = $team_name = $game1 = $game2 = $fees = "";

	// Get values and test
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$player_id 	= 	test_input($_POST["player_id"]);
		$name 		= 	test_input($_POST["name"]);
		$team_name 	= 	test_input($_POST["team_name"]);
		$game1 		= 	test_input($_POST["game1"]);
		$game2 		= 	test_input($_POST["game2"]);
		$fees		=	test_input($_POST["fees"]);
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
    echo "Connected successfully\n";

    $sql = "SELECT player_id FROM register WHERE player_id = '$player_id'";
    $result = $conn->query($sql);

    // Final check if ID not already used
    if($result->num_rows == 0) {
    	$sql = "INSERT INTO register(player_id, name, team_name, game1, game2, fees_paid) 
    			VALUES('$player_id', '$name', '$team_name', '$game1', '$game2', '$fees')";

    	if ($conn->query($sql) === TRUE) {
	        echo "New record created successfully\n";
	    } else {
	        echo "Error: " . $sql . "<br>" . $conn->error;
	    }
    } else {
    	echo "ID Mismatch";
    }
?>