<!DOCTYPE html>
<html>

<head>
    <title>Rohan Anand</title>
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
                            <input type="number" class="form-control" id="id" required="required">
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