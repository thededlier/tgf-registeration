<?php 
	include 'connect.php';

	session_start();

	// Team 1
	if(!empty($_GET['team1'])) {
		$team1 = $_GET['team1'];
		$sql = "SELECT * FROM team_game_r1 WHERE team_name like '%$team1%'";

		$result = $conn->query($sql);

		while ($row = $result->fetch_assoc()) {
			echo '<a>' . $row['team_name'] . "&nbsp&nbsp&nbsp" . $row['game'] . '</a>';
		}
	}
	// Team 2
	if(!empty($_GET['team2'])) {
		$team2 = $_GET['team2'];
		$sql = "SELECT * FROM team_game_r1 WHERE team_name like '%$team2%'";

		$result = $conn->query($sql);

		while ($row = $result->fetch_assoc()) {
			echo '<a>' . $row['team_name'] . "&nbsp&nbsp&nbsp" . $row['game'] . '</a>';
		}
	}
?>