<?php
    include '/process/connect.php';

    session_start();
    // Status of previous form if submited
    if(isset($_SESSION["status"]) && !empty($_SESSION["status"])) {
        echo $_SESSION["status"] . "<br>";
        session_unset(); 
    }
    if(isset($_SESSION["id_unlock"]) && !empty($_SESSION["id_unlock"])) {
        echo $_SESSION["id_unlock"] . " unlocked successfully";
        session_unset();
    }

    // Locking Algorithm
    // [START LOCK]
    // Determine ID to set
    $sql = "SELECT * FROM register order by player_id asc";
    $result = $conn->query($sql);

    $check = "TRUE";
    $id = "TGF170001";
    if ($result->num_rows > 0) {
        // Check used values
        while($row = $result->fetch_assoc()) {
            while($check) {
                if($id != $row["player_id"]) {
                    // Check if locked
                    $sql = "SELECT * FROM locks where lock_id = '$id'";
                    $locks = $conn->query($sql);
                    if($locks->num_rows == 0) {
                        $check = "FALSE";
                        break;
                    }
                } 
                $id ++;
            }
            if(!$check)
                break;
        }
    } else {
        $sql = "SELECT * FROM locks order by lock_id asc";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                if($id != $row["lock_id"]) {
                    break;
                } else {
                    $id = $row["lock_id"];
                }
                $id ++;
            }
        } else {
            // Initialize. This is the start of entering data
            $id = "TGF170001";
        }
    }
    // add lock
    $sql = "INSERT INTO locks(lock_id) 
            VALUES('$id')";
    if ($conn->query($sql) === TRUE) {
        ;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    // [STOP LOCK]
?> 

<!DOCTYPE html>
<html>

<head>
    <title>TGF - Registration</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <!-- Custom stylesheet -->
    <link rel="stylesheet" href="./css/stylesheet.css">
    <link rel="stylesheet" href="./css/sidebar.css">
</head>

<body>

    <div id="wrapper">

        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <ul class="sidebar-nav">
                <li class="sidebar-brand">
                    <a href="index.html">
                        TGF
                    </a>
                </li>
                <li>
                    <a href="register.php"> New Registration </a>
                </li>
                <li>
                    <a href="match.php"> Match Making </a>
                </li>
                <li>
                    <a href="locks.php"> Locks </a>
                </li>
                <li>
                    <a href="start-match.php"> Start Match </a>
                </li>
            </ul>
        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <div class="row">

                    <div class="header">
                        <h1> Participant Registration</h1>
                    </div>
                    
                    <form class="form-horizontal" action="/process/process_register.php" method="POST">
                        <div class="col-lg-6 col-xs-12">
                            <div class="form-group">
                                <label class="control-label col-lg-4 col-xs-3" for="player_id">ID</label>
                                <div class="col-lg-8 col-xs-9">
                                    <input type="text" class="form-control" id="player_id" name="player_id" required="required" readonly
                                            value="<?php echo $id; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-lg-4 col-xs-3" for="name">Name</label>
                                <div class="col-lg-8 col-xs-9">
                                    <input type="text" class="form-control" id="name" name="name" required="required">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-lg-4 col-xs-3" for="team_name">Team Name</label>
                                <div class="col-lg-8 col-xs-9">
                                    <input type="text" class="form-control" id="team_name" name="team_name">
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 col-xs-12">
                            <div class="form-group">
                                <label class="control-label col-lg-4 col-xs-3" for="game1">Game 1</label>
                                <div class="col-lg-8 col-xs-9">
                                    <input type="text" class="form-control" id="game1" name="game1" required="required">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-lg-4 col-xs-3" for="game2">Game 2</label>
                                <div class="col-lg-8 col-xs-9">
                                    <input type="text" class="form-control" id="game2" name="game2" required="required">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-lg-4 col-xs-3" for="fees">Fees Paid</label>
                                <div class="col-lg-8 col-xs-9">
                                    <input type="number" class="form-control" id="fees" name="fees" required="required">
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary"> Submit</button>
                    </form>
                </div>

            </div>
        </div>
        <!-- /#page-content-wrapper -->
    </div>

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="./js/bootstrap.min.js"></script>

    <!-- Menu Toggle Script -->
    <script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
    </script>

</body>

</html>