<?php 
include "./shared.php"; 


$given_json  = json_decode(file_get_contents('php://input'));


$db_connection = connect_and_return_db($db_server_host, $db_username, $db_password);
create_db($db_connection);
use_db($db_connection);
create__contact_me__table($db_connection);
$fname = $given_json->first_name;
$lname = $given_json->last_name;
$email = $given_json->email;
insert__contact_me__item($db_connection, $fname, $lname, $email);
echo 200;

?>