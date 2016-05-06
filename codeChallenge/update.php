<?php session_start();?>
    <!DOCTYPE html>

    <meta charset="UTF-8">
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <script src="script.js"></script>

    </head>

    <body onload="loadBody()">
        <div class="container">

            <div class="panel panel-primary">

                <div class="panel-heading">AutoMobile Maintainence App</div>

                <div class="panel-body">

                    <form role="form" method="post" name="myForm2" action="maintainanceController.php">
                        <div id="error"></div>

                        <div>
                            <label for="requestId">Maintainence Request Id </label>
                            <input type="text" name="requestId" id="requestId" class="form-control" value=<?php echo $_SESSION[ "MaintainanceRequestId"] ?> required disabled>
                        </div>

                        <div>
                            <label for="make">Make of your Car</label>
                            <input type="text" name="make" id="make" class="form-control" required>
                        </div>

                        <div>
                            <label for="model">Model of your Car</label>
                            <input type="text" name="model" id="model" class="form-control" required>
                        </div>

                        <div>
                            <label for="mfgYear">Manufacturing Year of your Car</label>
                            <input type="text" name="mfgYear" id="mfgYear" class="form-control" required>
                        </div>

                        <div>
                            <label for="odometerReading">Odometer Reading of your Car</label>
                            <input type="text" name="odometerReading" id="odometerReading" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="carType">Select Car Type:</label>
                            <select name="carType" id="carType" class="form-control" onchange="loadMaintainceActivities()" required>

                            </select>
                        </div>

                        <div class="form-group">
                            <label for="maintainance">Select Maintainance Activity:</label>
                            <select name="maintainance[]" id="maintainance" class="form-control" multiple required>
                                <option id="">-Select-</option>

                            </select>

                        </div>

                        <input type="hidden" name="page_form" value="update">
                        
                        <input type="submit" onclick="validateData()" value="Update"> </form>


                </div>

            </div>

        </div>

    </body>

    </html>
