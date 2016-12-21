 <?php
    include '/process/connect.php';

    session_start();
    if(isset($_SESSION["id_unlock"]) && !empty($_SESSION["id_unlock"])) {
        echo $_SESSION["id_unlock"] . " unlocked successfully";
        session_unset();
    }
?> 

<!DOCTYPE html>
<html>

<head>
    <title>TGF - Locks</title>
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
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <th>Locked ID</th>
                        <th>Time of Lock</th>
                        <th></th>
                    </thead>
                    <tbody>
                        <?php
                            // Retrieve locks
                            // [START FETCH_LOCKS]
                            $sql = "SELECT * FROM locks order by lock_id asc";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    $html = "<form action='/process/process_unlock.php' method='POST'>" .
                                                "<input type='hidden' name='lock_id' value='" . $row["lock_id"] . "'>" .
                                                "<tr>" .
                                                    "<td>" . $row["lock_id"] . "</td>" .
                                                    "<td>" . $row["timestamp"] . "</td>" .
                                                    "<td>" . "<button type='submit' id='>" . $row["lock_id"] . "'>Unlock</button>" . "</td>" .
                                                "</tr>" .
                                            "</form>";
                                    echo $html;
                                }
                            } else {
                                echo "No Locks Found";
                            }
                            // [END FETCH_LOCKS]
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>

</html>