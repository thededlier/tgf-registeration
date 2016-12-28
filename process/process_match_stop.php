<?php 
	include '/connect.php';

	session_start();

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$team1 = $_POST['team1'];
		$team2 = $_POST['team2'];
		$round = $_POST['round'];
		$game = $_POST['game'];

		$round_id = "";
		switch ($round) {
			case 1:
				$round_id = "r1-win";
				break;
			case 2:
				$round_id = "r2-win";
				break;
			case 3:
				$round_id = "r3-win";
				break;
			default:
				$round_id = "0";
				break;
		}

		$time = date("H:i:s");

		if (isset($_POST['team1-win'])) {
			// Team 1 declared winner by user
			echo $team1 . ' wins!';
			
			// [START UPDATES]
			$sql = "DELETE FROM matches_ongoing WHERE team1 = '$team1' AND team2 = '$team2' AND game = '$game'";
			$conn->query($sql);

			// Winning team update
			$sql = "UPDATE team_game_r1 SET round = '$round + 1', match_status = 'waiting', end_time = '$time'
					WHERE team_name = '$team1' AND game = '$game'";
			$conn->query($sql);

			$sql = "UPDATE register SET match_status1 = '$round_id' WHERE team_name = '$team1' AND game1 = '$game'";
			$conn->query($sql);

			// Losing team update
			$sql = "UPDATE team_game_r1 SET match_status = 'lose', end_time = '$time' 
					WHERE team_name = '$team2' AND game = '$game'";
			$conn->query($sql);

			$sql = "UPDATE register SET match_status1 = 'lose' WHERE team_name = '$team2' AND game1 = '$game'";
			$conn->query($sql);

			// [END UPDATES]

	    } else if (isset($_POST['team2-win'])) {
	        // Team 2 declared winner by user	
	        echo $team2 . ' wins!';
			
			// [START UPDATES]
			$sql = "DELETE FROM matches_ongoing WHERE team1 = '$team1' AND team2 = '$team2' AND game = '$game'";
			$conn->query($sql);

			// Winning team update
			$sql = "UPDATE team_game_r1 SET round = '$round + 1', match_status = 'waiting', end_time = '$time' 
					WHERE team_name = '$team2' AND game = '$game'";
			$conn->query($sql);

			$sql = "UPDATE register SET match_status1 = '$round_id' WHERE team_name = '$team2' AND game1 = '$game'";
			$conn->query($sql);

			// Losing  team update
			$sql = "UPDATE team_game_r1 SET match_status = 'lose', end_time = '$time'
					WHERE team_name = '$team1' AND game = '$game'";
			$conn->query($sql);

			$sql = "UPDATE register SET match_status1 = 'lose' WHERE team_name = '$team1' AND game1 = '$game'";
			$conn->query($sql);

			// [END UPDATES]
	    }
	} else {
		die(header("Location: ../start-match.php"));
	}
	
?>