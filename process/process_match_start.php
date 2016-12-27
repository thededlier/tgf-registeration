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
		$row = $result->fetch_assoc();
		if($row["match_status"] != "waiting") {
			$_SESSION["error"] = "Team " . $team1 . " match is already " . $row["match_status"];
			header("Location: ../start-match.php");
		}
		if($row["round"] != $round) {
			$_SESSION["error"] = "Team " . $team1 . " is in round " . $row["round"];
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
		$row = $result->fetch_assoc();
		if($row["match_status"] != "waiting") {
			$_SESSION["error"] = "Team " . $team2 . " match is already " . $row["match_status"];
			header("Location: ../start-match.php");
		}
		if($row["round"] != $round) {
			$_SESSION["error"] = "Team " . $team2 . " is in round " . $row["round"];
			header("Location: ../start-match.php");
		}
	}
?>