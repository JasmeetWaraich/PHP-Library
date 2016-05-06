<?php
abstract class Car {
	var $make;
	var $model;
	var $mfgYear;
	var $odometerReading;

	function __construct($make, $model, $mfgYear, $odometerReading)
	{
		$this->make = $make;
		$this->model = $model;
		$this->mfgYear = $mfgYear;
		$this->odometerReading = $odometerReading;
	}

	abstract function changeOil();
	abstract function tireRotation();
	abstract function wheelAlignment();

	public function getMake(){
		return $this->make;
	}

	public function setMake($make){
		$this->make = $make;
	}

	public function getModel(){
		return $this->model;
	}

	public function setModel($model){
		$this->model = $model;
	}

	public function getMfgYear(){
		return $this->mfgYear;
	}

	public function setMfgYear($mfgYear){
		$this->mfgYear = $mfgYear;
	}

	public function getOdometerReading(){
		return $this->odometerReading;
	}

	public function setOdometerReading($odometerReading){
		$this->odometerReading = $odometerReading;
	}
	
}

class electricCar extends Car
{
	
	function __construct($make, $model, $mfgYear, $odometerReading)
	{
		parent::__construct($make, $model, $mfgYear, $odometerReading);
	}

	function tireRotation(){
		return "Electric Car: tireRotation done";
	}

	function wheelAlignment(){
		return "Electric Car: wheel alignment done";
	}

	function replaceSparkPlug(){
		return "Electric Car: Spark Plug changed";
	}
    
    function changeOil(){
        throw new Exception("Oil change not required for Electric Car");
    }
}

class gasCar extends Car
{
	
	function __construct($make, $model, $mfgYear, $odometerReading)
	{
		parent::__construct($make, $model, $mfgYear, $odometerReading);
	}

	function tireRotation(){
		return "Gas Car: tireRotation done";
	}

	function wheelAlignment(){
		return "Gas Car: wheel alignment done";
	}

	function changeOil(){
		return "Gas Car: oil change done";
	}
}

class dieselCar extends Car
{
	
	function __construct($make, $model, $mfgYear, $odometerReading)
	{
		parent::__construct($make, $model, $mfgYear, $odometerReading);
	}

	function tireRotation(){
		return "Diesel Car: tireRotation done";
	}

	function wheelAlignment(){
		return "Diesel Car: wheel alignment done";
	}

	function changeOil(){
		return "Diesel Car: oil change done";
	}
}


class MaintainanceRequest {
    var $dbConnection;    
    
    function __construct(){
       
        if(empty($this->dbConnection)){
        $host = 'localhost';
        $user = 'user';
        $pass = 'password';
        $this->dbConnection = new mysqli($host, $user, $pass);   
        $this->setUpDatabase();
        }
       
    }
    
    function setUpDatabase() {   
        
        $query = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = 'automobile'";
        $result = $this->dbConnection->query($query);
        
            if($result->fetch_assoc()["SCHEMA_NAME"]!="automobile"){        
            $query = "create database IF NOT EXISTS Automobile";
            $result = $this->dbConnection->query($query);
           
            $query = "CREATE TABLE IF NOT EXISTS `automobile`.`carTypes` ( `carTypeId` INT NOT NULL AUTO_INCREMENT , `carTypes` VARCHAR(25) NOT NULL , PRIMARY KEY (`carTypeId`)) ENGINE = InnoDB";
            $result = $this->dbConnection->query($query);

            $query = "CREATE TABLE IF NOT EXISTS `automobile`.`MaintainanceActivity` ( `MaintainanceActivityId` INT NOT NULL AUTO_INCREMENT , `maintaienceActivityDetails` VARCHAR(25) NOT NULL , PRIMARY KEY (`MaintainanceActivityId`)) ENGINE = InnoDB";
            $result = $this->dbConnection->query($query);

            $query = "CREATE TABLE IF NOT EXISTS `automobile`.`MaintainanceRequest` ( `MaintainanceRequestId` INT NOT NULL AUTO_INCREMENT , `make` VARCHAR(25) NOT NULL , `model` VARCHAR(20) NOT NULL , `mfgYear` INT NOT NULL , `odometerReading` INT NOT NULL , `dateOfMaintainance` INT NOT NULL , `carTypeId` INT NOT NULL , `maintainanceRequest` VARCHAR(100) NOT NULL, PRIMARY KEY (`MaintainanceRequestId`)) ENGINE = InnoDB";
            $result = $this->dbConnection->query($query);          

            $query = "INSERT INTO `automobile`.`carTypes` ( `carTypeId`, `carTypes`) VALUES (1, 'ELECTRIC')";
            $result = $this->dbConnection->query($query);

            $query = "INSERT INTO `automobile`.`carTypes` ( `carTypeId`, `carTypes`) VALUES (2, 'GAS')";
            $result = $this->dbConnection->query($query);

            $query = "INSERT INTO `automobile`.`carTypes` ( `carTypeId`, `carTypes`) VALUES (3, 'DIESEL')";
            $result = $this->dbConnection->query($query);
           
        }
    }
    
    function storeMaintainanceRequest($make, $model, $mfgYear, $odometerReading, $dateOfMaintainance, $carType, $maintainanceActivitiesRequested){
        
        $query = "INSERT INTO `automobile`.`MaintainanceRequest`(`make`, `model`, `mfgYear`, `odometerReading`, `dateOfMaintainance`, `carTypeId`, `maintainanceRequest`) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $statement = $this->dbConnection->prepare($query);
        $statement->bind_param("ssiisis", $make, $model, $mfgYear, $odometerReading, $dateOfMaintainance, $this->getCarTypeId($carType), $maintainanceActivitiesRequested);       
        $result = $statement->execute();         
        if($result == false){
            throw new Exception("Maintainance Request cannot be saved");
        }
        $query = "SELECT MaintainanceRequestId from `automobile`.`MaintainanceRequest` ORDER BY MaintainanceRequestId DESC LIMIT 1";
        $result=$this->dbConnection->query($query);
        return $result->fetch_assoc()["MaintainanceRequestId"];
    }
    
    function getCarTypeId($carType){
        $query = "select carTypeId from `automobile`.`carTypes` where carTypes='".$carType."'";
        $result = $this->dbConnection->query($query);
        return $result->fetch_assoc()["carTypeId"];
    }
    
    function getLastStoredReuqest(){
        $query = "SELECT * from `automobile`.`MaintainanceRequest` ORDER BY MaintainanceRequestId DESC LIMIT 1";
        $result = $this->dbConnection->query($query);
        return $result->fetch_assoc();     

    }
    
    function updateMaintainanceRequest($make, $model, $mfgYear, $odometerReading, $dateOfMaintainance, $carType, $maintainanceActivitiesRequested, $maintainanceRequestId){
        $query = "UPDATE `automobile`.`MaintainanceRequest` SET `make`=?,`model`=?,`mfgYear`= ?,`odometerReading`=?,`dateOfMaintainance`=?,`carTypeId`=?,`maintainanceRequest`=? WHERE `MaintainanceRequestId`= ?";
        $statement = $this->dbConnection->prepare($query);      
        $statement->bind_param("ssiisisi", $make, $model, $mfgYear, $odometerReading, $dateOfMaintainance, $this->getCarTypeId($carType), $maintainanceActivitiesRequested, $maintainanceRequestId);
        $result = $statement->execute();     
        if($result == false){
            throw new Exception("Maintainance Request cannot be updated");
        }
        return $result;
    
    }
    
    function getRowById($id){
        $query = "SELECT * from `automobile`.`MaintainanceRequest` WHERE `MaintainanceRequestId`= ?" ;
        $statement = $this->dbConnection->prepare($query);
        $statement->bind_param("i", $id);
        $result = $statement->execute();   
        return $result->fetch_assoc();
    }
    
    function deleteMaintainanceRequest($id){        
        $query = "DELETE FROM `automobile`.`MaintainanceRequest` WHERE `MaintainanceRequestId`= ?" ;
        $statement = $this->dbConnection->prepare($query);
        $statement->bind_param("i", $id);       
        $result = $statement->execute();   
        return $result;
    }
    
}


    


?>
