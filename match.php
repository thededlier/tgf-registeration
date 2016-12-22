<?php
    include '/process/connect.php';
?> 

<!DOCTYPE html>
<html>

<head>
    <title>TGF - Match Making</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="./css/bootstrap.min.css">    
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="./js/bootstrap.min.js"></script>
    <!-- Custom stylesheet -->
    <link rel="stylesheet" href="./css/stylesheet.css">
</head>

<body>

    <div class="container">
        <div class="row">
            <ul class="nav nav-tabs">
              <li class="active"><a data-toggle="tab" href="#all-stats">All Status</a></li>
              <li><a data-toggle="tab" href="#cod">COD</a></li>
            </ul>

            <div class="tab-content">
                <div id="all-stats" class="tab-pane fade in active">
                    <h1> Status of All Teams and Players </h1>

                    <h4>
                        Team Matches Remaining : 
                        <?php
                            // Get teams matches remaining
                            $sql = "SELECT COUNT(DISTINCT team_name, game1) FROM register WHERE match_status1 = 'waiting'";
                            $result = $conn->query($sql);
                            $row = mysqli_fetch_assoc($result);
                            $team_remain_count = $row["COUNT(DISTINCT team_name, game1)"];
                            echo $team_remain_count; 
                        ?>  
                    </h4> 

                    <h4>
                        Team Matches ongoing : 
                        <?php
                            // Get teams matches ongoing
                            $sql = "SELECT COUNT(DISTINCT team_name) FROM register WHERE match_status1 = 'ongoing'";
                            $result = $conn->query($sql);
                            $row = mysqli_fetch_assoc($result);
                            $team_ongo_count = $row["COUNT(DISTINCT team_name)"];
                            echo $team_ongo_count; 
                        ?>  
                    </h4> 

                    <h4>
                        Team Matches Completed : 
                        <?php
                            // Get teams matches completed
                            $sql = "SELECT COUNT(DISTINCT team_name) FROM register WHERE match_status1 = 'completed'";
                            $result = $conn->query($sql);
                            $row = mysqli_fetch_assoc($result);
                            $team_completed_count = $row["COUNT(DISTINCT team_name)"];
                            echo $team_completed_count; 
                        ?>  
                    </h4> 
                    
                    <h4> 
                        Single Player Matches remaining : 
                        <?php 
                            // Get single matches remaining
                            $sql = "SELECT COUNT(DISTINCT player_id) FROM register WHERE match_status2 = 'waiting'";
                            $result = $conn->query($sql);
                            $row = mysqli_fetch_assoc($result);
                            $single_remain_count = $row["COUNT(DISTINCT player_id)"];
                            echo $single_remain_count; 
                        ?>
                    </h4>

                    <h4> 
                        Single Player Matches ongoing : 
                        <?php 
                            // Get single matches ongoing
                            $sql = "SELECT COUNT(DISTINCT player_id) FROM register WHERE match_status2 = 'ongoing'";
                            $result = $conn->query($sql);
                            $row = mysqli_fetch_assoc($result);
                            $single_ongo_count = $row["COUNT(DISTINCT player_id)"];
                            echo $single_ongo_count; 
                        ?>
                    </h4>

                    <h4> 
                        Single Player Matches completed : 
                        <?php 
                            // Get single matches completed
                            $sql = "SELECT COUNT(DISTINCT player_id) FROM register WHERE match_status2 = 'completed'";
                            $result = $conn->query($sql);
                            $row = mysqli_fetch_assoc($result);
                            $single_completed_count = $row["COUNT(DISTINCT player_id)"];
                            echo $single_completed_count; 
                        ?>
                    </h4>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <th> Player ID </th>
                                <th> Name </th>
                                <th> Team Name </th>
                                <th> Game 1 </th>
                                <th> Game 2 </th>
                                <th> Fees Paid </th>
                                <th> Timestamp </th>
                                <th> Match Status 1 </th>
                                <th> Match Status 2 </th>
                            </thead>
                            <tbody>
                                <?php
                                    // Fetch All Stats
                                    // [START FETCH_ALL_STATS]
                                    $sql = "SELECT * FROM register order by player_id asc";
                                    $all_register = $conn->query($sql); 
                                    
                                    if ($all_register->num_rows > 0) {
                                        while($row = $all_register->fetch_assoc()) {
                                            $html = "<tr>" .
                                                        "<td>" . $row["player_id"] . "</td>" .
                                                        "<td>" . $row["name"] . "</td>" .
                                                        "<td>" . $row["team_name"] . "</td>" .
                                                        "<td>" . $row["game1"] . "</td>" .
                                                        "<td>" . $row["game2"] . "</td>" .
                                                        "<td>" . $row["fees_paid"] . "</td>" .
                                                        "<td>" . $row["timestamp"] . "</td>" .
                                                        "<td>" . $row["match_status1"] . "</td>" .
                                                        "<td>" . $row["match_status2"] . "</td>" .
                                                    "</tr>";
                                            echo $html;
                                        }
                                    } else {
                                        echo "No registrations found";
                                    }
                                    // [END FETCH_ALL_STATS]
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div id="cod" class="tab-pane fade">
                    <h1> Call of Duty </h1>

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <th> Team Name </th>
                                <th> Match Status </th>
                                <th> Start Time </th>
                                <th> End Time </th>
                                <th> Last Update </th>
                                <th> Members </th>
                            </thead>
                            <tbody>
                                <?php
                                    // Fetch All Stats
                                    // [START FETCH_COD_STATS]
                                    $sql = "SELECT * FROM team_game_r1 WHERE game = 'COD' order by last_update asc";
                                    $all_register = $conn->query($sql); 
                                    
                                    if ($all_register->num_rows > 0) {
                                        while($row = $all_register->fetch_assoc()) {
                                            $html = "<tr>" .
                                                        "<td>" . $row["team_name"] . "</td>" .
                                                        "<td>" . $row["match_status"] . "</td>" .
                                                        "<td>" . $row["start_time"] . "</td>" .
                                                        "<td>" . $row["end_time"] . "</td>" .
                                                        "<td>" . $row["last_update"] . "</td>" .
                                                        "<td>" . $row["members"] . "</td>" .
                                                    "</tr>";
                                            echo $html;
                                        }
                                    } else {
                                        echo "No registrations found";
                                    }
                                    // [END FETCH_COD_STATS]
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>