function getCarTypes() {
        carTypes = new Array("Electric", "Gas", "Diesel");
        var outputString = "";
        outputString += "<option id='' value=''>-Select-</option>";
        for (index = 0; index < carTypes.length; index++) {
            outputString += "<option id=" + carTypes[index] + ">" + carTypes[index]
            "</option>";
        }
        document.getElementById("carType").innerHTML = outputString;
    }

    function loadBody(){
        getCarTypes();
    }
    function loadMaintainceActivities() {
        var e = document.getElementById("carType");
        selVal = e.options[e.selectedIndex].value;
        if (selVal == "Electric") {
            maintainenceActivities = new Array("Wheel Alignment", "Tire Rotation", "Replace Spark Plug");
        } else {
            maintainenceActivities = new Array("Wheel Alignment", "Tire Rotation", "Change Oil");
        }
         outputString = "<option id=''>-Select-</option>";
        for (index = 0; index < maintainenceActivities.length; index++) {
            outputString += "<option id=" + maintainenceActivities[index] + ">" + maintainenceActivities[index]
            "</option>";
        }
        document.getElementById("maintainance").innerHTML = outputString;
    }

    function validateData() {
        make = document.getElementById("make").value;
        model = document.getElementById("model").value;
        mfgYear = document.getElementById("mfgYear").value;
        odometerReading = document.getElementById("odometerReading").value;
        carType = document.getElementById("carType").value;
        maintainenceActivities = new Array();
        for (i = 0; i < myForm.maintainance.options.length; i++) {
            if (myForm.maintainance.options[i].selected) {
                maintainenceActivities.push(myForm.maintainance.options[i].value);
            }
        }

        errorMsg = new Array();
        if (make == "") {
            errorMsg.push("You have not provided the make of your car");
        } 
        if (model == "") {
            errorMsg.push("You have not provided the model of your car");
        } 
        if (mfgYear == "") {
            errorMsg.push("You have not provided the mfg. year of your car");
        } 
        if (odometerReading == "") {
            errorMsg.push("You have not provided the odometer reading of your car")
        } 
        if(carType== ""){
            errorMsg.push("You have not provided the type of your car");
        } 
        if(maintainenceActivities.length==0){
            errorMsg.push("You have not provided maintainance that you want to get done");
        }
        displayErrorMsg(errorMsg);
    }

        function displayErrorMsg(errorMsg){
        if(errorMsg.length != 0) {
            errorString = "<h4>Errors</h4>"
            errorString += "<ul>";
            for(i = 0;i<errorMsg.length; i++) {
                errorString += "<li>" + errorMsg[i] +"</li>";
            }
            errorString += "</ul>";
            document.getElementById("error").innerHTML = errorString;
        }
    }
