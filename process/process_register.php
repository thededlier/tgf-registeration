<?php
	include '/process/connect.php';
	
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

    // [START SUBMISSION]
    // Final check if ID not already used
    $sql = "SELECT player_id FROM register WHERE player_id = '$player_id'";
    $result = $conn->query($sql);

    if($result->num_rows == 0) {
		// Add team name round1 table and check if team members exceed limit
	    if($team_name != "") {
    		$sql = "SELECT members FROM team_game_r1 WHERE team_name = '$team_name' AND game = '$game1'";
    		$result = $conn->query($sql);
    		$row = $result->fetch_assoc();
    		if($result->num_rows == 0) {
    			$members = 1;
    			$sql = "INSERT INTO team_game_r1(team_name, round, match_status, game, members)
    					VALUES('$team_name', 1, '$match_status1', '$game1', '$members')";
    			$conn->query($sql);
    		} else if($row["members"] < 5) {
    			$members = $row["members"];
    			$members ++;
    			$sql = "UPDATE team_game_r1 SET members = '$members' WHERE team_name = '$team_name'";
    			$conn->query($sql);
    		} else {
    			// Team full
    			$_SESSION["status"] = "This team is already full. Please choose another team name";
				header('Location: /register.php');
    		}
	    }

    	$sql = "INSERT INTO register(player_id, name, team_name, game1, game2, fees_paid, match_status1, match_status2) 
    			VALUES('$player_id', '$name', '$team_name', '$game1', '$game2', '$fees', '$match_status1', '$match_status2')";

    	if ($conn->query($sql) === TRUE) {
    		$flag = "TRUE";
	        echo "New record created successfully\n";
	    } else {
	        echo "Error: " . $sql . "<br>" . $conn->error;
	    }
    } else {
    	// ID Already used
    	echo "ID Mismatch :: The ID is already in use";
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
    if($flag == "TRUE")
    	$_SESSION["status"] 	=	$player_id . " registered successfully";
    else 
    	$_SESSION["status"]		=	$player_id . " failed to register";
    header('Location: /register.php');
?>