<?php
require 'model.php';      
class maintainenceController {
	var $carType;
	var $carObj;
    var $make;
    var $model;
    var $mfgYear;
    var $odometerReading;
    var $maintainanceActivities;
    var $finalSummary;
    var $maintainRequestObj;
    var $pageSource;
    

    function __construct() {
        if(!empty($_POST)){
            $this->make = $_POST["make"];
            $this->model = $_POST["model"];
            $this->mfgYear = $_POST["mfgYear"];
            $this->odometerReading = $_POST["odometerReading"];
            $this->carType = $_POST["carType"];      
            $this->maintainanceActivities= implode(',', $_POST["maintainance"]); 
            $this->pageSource = $_POST['page_form'];
            $this->maintainRequestObj = new MaintainanceRequest();   
            $this->initializeCarObject();
        }
    }
    
    function initializeCarObject(){ 
        
        switch($this->carType) {
            case "Electric":
                $this->carObj = new electricCar($this->make, $this->model, $this->mfgYear, $this->odometerReading);
                break;
                
             case "Gas":
                $this->carObj = new gasCar($this->make, $this->model, $this->mfgYear, $this->odometerReading);                
                break;
            
            case "Diesel":
                $this->carObj = new dieselCar($this->make, $this->model, $this->mfgYear, $this->odometerReading);
                break; 
            
            default:
                throw new Exception("Invalid Car Type. Object cannot be initialized");
        }
    }
   
    function saveMaintainanceRequest() {             
     
          $id = $this->maintainRequestObj->storeMaintainanceRequest($this->carObj->getMake(), $this->carObj->getModel(), $this->carObj->getMfgYear(), $this->carObj->getOdometerReading(), date("Y-m-d H:i:s"), $this->carType, $this->maintainanceActivities);   
          $_SESSION["MaintainanceRequestId"] = $id;
          $_SESSION["PAGE_SOURCE"] = $this->pageSource;
          displayThanksPage();
        
    } 
    
    function displayRecentRequest() {
        $this->maintainRequestObj = new MaintainanceRequest();
        return $this->maintainRequestObj->getLastStoredReuqest();    

    }
    
    function updateRequest($maintainanceRequestId){
        $this->maintainRequestObj->updateMaintainanceRequest($this->carObj->getMake(), $this->carObj->getModel(), $this->carObj->getMfgYear(), $this->carObj->getOdometerReading(), date("Y-m-d H:i:s"), $this->carType, $this->maintainanceActivities, $maintainanceRequestId);
        $_SESSION["PAGE_SOURCE"] = $this->pageSource;
        displayThanksPage();
    }
    
    function takeAction(){
        if(!empty($_POST)){
            switch($this->pageSource){
                case "save":
                    $this->saveMaintainanceRequest();
                    break;
                case "update":
                    $this->updateRequest($_SESSION["MaintainanceRequestId"]);
                    break;
                default:
                    echo "Not a valid method call";
                    break;
            }
        }
    
    }
    
     function deleteRequest($maintainanceRequestId){    
         $this->maintainRequestObj = new MaintainanceRequest();
        return $this->maintainRequestObj->deleteMaintainanceRequest($maintainanceRequestId);
    }
   
}
    function displayThanksPage(){
        
        header("Location: Thanks.php");    
    }


   

session_start();
$obj = new maintainenceController();
$obj->takeAction();
//$obj->saveMaintainanceRequest();
?>
