<?php
require 'maintainanceController.php';   
function deleteCurrentRequest(){
    $obj = new maintainenceController();
    $id = $_SESSION["MaintainanceRequestId"];      
    $result = $obj->deleteRequest($_SESSION["MaintainanceRequestId"]);

   if($result == true){       
        header('Location: index.html');
       session_unset();
       session_destroy();

    } else {
        echo "Error! Can't Delete this record<br>Go back.";
    }
}
deleteCurrentRequest();
?>
