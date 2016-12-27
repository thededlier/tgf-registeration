<?php
    include '/process/connect.php';

    session_start();

    if(!empty($_SESSION["error"])) {
        echo $_SESSION["error"];
        session_unset($_SESSION["error"]);
    }

    // Set team values
    if(!empty($_GET["team1"])) {
        $_SESSION["team1"] = $_GET["team1"];
        $team1 = $_SESSION["team1"];
        
        if(!empty($_SESSION["team2"])) {
            $team2 = $_SESSION["team2"];
        } else {
            $team2 = "";
        }
    } else if(!empty($_GET["team2"])) {
        $_SESSION["team2"] = $_GET["team2"];
        $team2 = $_SESSION["team2"];

        if(!empty($_SESSION["team1"])) {
            $team1 = $_SESSION["team1"];
        } else {
            $team1 = "";
        }
    } else {
        session_unset();
        $team1 = $team2 = "";
    }
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
    <style>
        .live-search {
            width   : 400px;
            height  : 300px;
            border  : 1px solid #000000;
            display : none; 
        }

        .live-search a {
            display : block;
            width   : 98%;
            padding : 1%;
            font-size: 20px;
            border-bottom: 1px solid #000000;   
        }
    </style>


    <div class="container">
        <div class="row">
            <form class="form-horizontal" action="/process/process_match_start.php" method="POST">
                <div class="col-lg-6 col-xs-6">
                    <label class="radio-inline"><input type="radio" name="game" id="game" value="COD" checked>COD</label>
                    <label class="radio-inline"><input type="radio" name="game" id="game" value="DOTA">DOTA</label>
                    <label class="radio-inline"><input type="radio" name="game" id="game" value="CS">CS</label> 
                </div>

                <div class="col-lg-6 col-xs-6">
                    <div class="form-group">
                    <label class="control-label col-lg-4 col-xs-3" for="round">Round</label>
                        <div class="col-lg-8 col-xs-9">
                            <input type="number" class="form-control" id="round" name="round" required="required">
                        </div>
                    </div>
                </div>

                <div class="col-lg-5 col-xs-5">
                    <input type="text" id="team1" name="team1" class="form-control" value="<?php echo $team1; ?>"></input>
                    <div class="live-search" id="team1-res"></div>
                </div>
                
                <div class="col-lg-1 col-xs-2">
                    <button type="button" class="btn btn-danger btn-block" disabled> VS </button>
                </div>

                <div class="col-lg-5 col-xs-5">
                    <input type="text" id="team2" name="team2" class="form-control" value="<?php echo $team2; ?>"></input>
                    <div class="live-search" id="team2-res"></div>
                </div>

                <div class="col-lg-1 col-xs-12">
                    <button type="submit" name="submit" class="btn btn-sucess btn-block"> Start </button>
                </div>
            </form>
        </div>
    </div>


    <script type="text/javascript">
        // Live-search
        $(document).ready(function(e) {
            // Team 1
            $("#team1").keyup(function() {
                $("#team1-res").show();
                var team1 = $(this).val();
                $.ajax({
                    type    : 'GET',
                    url     : '/process/live_search.php',
                    data    : {team1 :  team1},
                    success : function(data) {
                        $("#team1-res").html(data);
                    }
                })
            });
            // Team 2
            $("#team2").keyup(function() {
                $("#team2-res").show();
                var team2 = $(this).val();
                $.ajax({
                    type    : 'GET',
                    url     : '/process/live_search.php',
                    data    : {team2 :  team2},
                    success : function(data) {
                        $("#team2-res").html(data);
                    }
                })
            });
        })
    </script>
</body>

</html>