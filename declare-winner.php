<?php
    include '/process/connect.php';

    session_start();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $match_id   =   test_input($_POST["no"]);
        $team1      =   test_input($_POST["team1"]);
        $team2      =   test_input($_POST["team2"]);
        $game       =   test_input($_POST["game"]);
        $round      =   test_input($_POST["round"]);
    } else {
        die(header("Location: start-match.php"));
    }

    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

?> 

<!DOCTYPE html>
<html>

<head>
    <title>TGF - Match Making</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="./css/bootstrap.min.css">    
    <!-- Custom stylesheet -->
    <link rel="stylesheet" href="./css/stylesheet.css">
    <link rel="stylesheet" href="./css/sidebar.css">
</head>

<body>
    <style>
        .live-search {
            width   : 400px;
            height  : 300px;
            border  : 1px solid #000000;
            display : block;
        }

        .live-search a {
            display : block;
            width   : 98%;
            padding : 1%;
            font-size: 20px;
            border-bottom: 1px solid #000000;   
        }
    </style>

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
                    <form class="form-horizontal" action="/process/process_match_stop.php" method="POST">
                        <div class="row">
                            <div class="col-lg-4 col-xs-4">
                                <h3>Game : <?php echo $game; ?></h3>
                                <input type="hidden" name="game" value="<?php echo $game; ?>"></input> 
                            </div>

                            <div class="col-lg-4 col-xs-4">
                                <h3>Round : <?php echo $round; ?></h3>
                                <input type="hidden" name="round" value="<?php echo $round; ?>"></input>
                            </div>

                            <div class="col-lg-4 col-xs-4">
                                <h3><input type="number" name="match_id" value="<?php echo $match_id; ?>"></input></h3>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-5 col-xs-5">
                                <input type="text" id="team1" name="team1" class="form-control" readonly value="<?php echo $team1; ?>"></input>
                            </div>
                            
                            <div class="col-lg-2 col-xs-2">
                                <button type="button" class="btn btn-danger btn-block" disabled> VS </button>
                            </div>

                            <div class="col-lg-5 col-xs-5">
                                <input type="text" id="team2" name="team2" class="form-control" readonly value="<?php echo $team2; ?>"></input>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-5 col-xs-5">
                                <button type="submit" name="team1-win" class="btn btn-success btn-lg">Winner</button>
                            </div>

                            <div class="col-lg-2 col-xs-2">
                            </div> 
                            <div class="col-lg-5 col-xs-5">
                                <button type="submit" name="team2-win" class="btn btn-success btn-lg">Winner</button>
                            </div>
                        </div>
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