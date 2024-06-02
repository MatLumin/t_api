<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');
header('Access-Control-Allow-Methods: *');
class Dbconnect{
  private $servername = "localhost";
  private $username = "root";
  private $password = "";
  private $dbname = "reactDB";
  public function connect(){
    try{
    $conn=new PDO('mysql:host='.$this->servername . ';dbname=' . $this->dbname.';charset=utf8;',$this->username,$this->password);
    $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    return $conn;
    }
    catch(Exception $e){
      echo 'Database Error:'.$e->getMessage();
    }
  }
}
?>