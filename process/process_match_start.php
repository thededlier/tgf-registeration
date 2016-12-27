<?php 
	include '/connect.php';

	session_start();

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$team1	 	= 	test_input($_POST["team1"]);
		$team2 		= 	test_input($_POST["team2"]);
		$game 		=	test_input($_POST["game"]);
		$round		=	test_input($_POST["round"]);
	}

	function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}

	// Check Team1
	$sql = "SELECT * FROM team_game_r1 WHERE team_name = '$team1' AND game = '$game'";
	$result = $conn->query($sql);
	
	if($result->num_rows == 0) {
		$_SESSION["error"] = "Team " . $team1 . " not found";
		header("Location: ../start-match.php");
	} else {
		$row_team1 = $result->fetch_assoc();
		if($row_team1["match_status"] == "ongoing") {
			$_SESSION["error"] = "Team " . $team1 . " match is already " . $row_team1["match_status"];
			header("Location: ../start-match.php");
		}
		if($row_team1["round"] != $round) {
			$_SESSION["error"] = "Team " . $team1 . " is in round " . $row_team1["round"];
			header("Location: ../start-match.php");
		}
	}

	// Check Team2
	$sql = "SELECT * FROM team_game_r1 WHERE team_name = '$team2' AND game = '$game'";
	$result = $conn->query($sql);
	
	if($result->num_rows == 0) {
		$_SESSION["error"] = "Team " . $team2 . " not found";
		header("Location: ../start-match.php");
		
	} else {
		$row_team2 = $result->fetch_assoc();
		if($row_team2["match_status"] == "ongoing") {
			$_SESSION["error"] = "Team " . $team2 . " match is already " . $row_team2["match_status"];
			header("Location: ../start-match.php");
		}
		if($row_team2["round"] != $round) {
			$_SESSION["error"] = "Team " . $team2 . " is in round " . $row_team2["round"];
			header("Location: ../start-match.php");
		}
	}

	$time = date("H:i:s");

	// Add to ongoing matches
	$sql = "INSERT INTO matches_ongoing(team1, team2, game, round) 
			VALUES('$team1', '$team2', '$game', '$round')";
	$result = $conn->query($sql);

	// Update team register
	$sql = "UPDATE team_game_r1 SET match_status = 'ongoing' AND start_time = '$time'
	 		WHERE (team_name = '$team1' OR team_name = '$team2') AND game = '$game'";
	$result = $conn->query($sql);

	// Update individual players status
	$sql = "UPDATE register SET match_status1 = 'ongoing' WHERE (team_name = '$team1' OR team_name = '$team2') AND game1 = '$game'";
	$result = $conn->query($sql);

	header("Location: ../start-match.php?ms=start")
?>