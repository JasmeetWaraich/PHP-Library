<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<center>
    <?php
    require 'maintainanceController.php';   
    echo "<h1>Thanks for submitting the following request</h1>"; 
    displaySavedRequest();
    
    
  
?>

        <br>
        <br>
        <?php if($_SESSION["PAGE_SOURCE"] == "save") { ?>
            <button onclick="location='update.php'">Update Your Request</button>&nbsp;&nbsp;
            <?php } ?>
                <button onclick="location='delete.php'">Delete This Request</button>
                <button onclick="location='index.html'">Home Page</button>

</center>
<?php

function displaySavedRequest(){
    $obj = new maintainenceController();
    $result = $obj->displayRecentRequest();
    displayInTabularForm($result);
    
}



function displayInTabularForm($result){
    echo "<table border=1>";
    foreach($result as $key=>$value){
        echo "<tr>";
        echo "<td style='text-transform:capitalize'><strong>$key</strong> </td><td> $value</td>";
        echo "</tr>";
    }
    echo "</table>";
}


?>
    <script>
        function callToPHP() {

        }

    </script>
