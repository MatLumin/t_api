<?php

include "database.php";
$object=new Dbconnect;
$conn=$object->connect();
header('Content-Type: application/json');
$sql="";

$endpoint = $_SERVER['REQUEST_URI'];
if($endpoint=='/project')
	{
	$sql='select * from projectpricecardlist';
	$stmt=$conn->query($sql);
	$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
	echo json_encode($result);
	}


else if($endpoint == '/work')
	{
	$sql="SELECT * FROM `work`";
	$stmt=$conn->query($sql);
	$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
	echo json_encode($result);
	}


?>