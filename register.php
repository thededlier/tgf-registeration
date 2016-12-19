 <?php
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
    echo "Connected successfully";


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
        echo "New record created successfully";
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

            <div class="header">
                <h1> Participant Registration</h1>
            </div>
            
            <form class="form-horizontal">
                <div class="col-lg-6 col-xs-12">
                    <div class="form-group">
                        <label class="control-label col-lg-4 col-xs-3" for="id">ID</label>
                        <div class="col-lg-8 col-xs-9">
                            <input type="text" class="form-control" id="id" required="required" disabled
                                    value="<?php echo $id; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-lg-4 col-xs-3" for="name">Name</label>
                        <div class="col-lg-8 col-xs-9">
                            <input type="text" class="form-control" id="name" required="required">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-lg-4 col-xs-3" for="team_name">Team Name</label>
                        <div class="col-lg-8 col-xs-9">
                            <input type="text" class="form-control" id="team_name">
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-xs-12">
                    <div class="form-group">
                        <label class="control-label col-lg-4 col-xs-3" for="game1">Game 1</label>
                        <div class="col-lg-8 col-xs-9">
                            <input type="text" class="form-control" id="game1" required="required">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-lg-4 col-xs-3" for="game2">Game 2</label>
                        <div class="col-lg-8 col-xs-9">
                            <input type="text" class="form-control" id="game2" required="required">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-lg-4 col-xs-3" for="fees">Fees Paid</label>
                        <div class="col-lg-8 col-xs-9">
                            <input type="number" class="form-control" id="fees" required="required">
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary"> Submit</button>
            </form>
        </div>
    </div>

</body>

</html>