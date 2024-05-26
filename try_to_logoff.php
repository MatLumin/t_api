<?php 
include "./shared.php"; 
$db_connection = connect_and_return_db($db_server_host, $db_username, $db_password);
create_db($db_connection);
use_db($db_connection);

create__normal_user_session__table($db_connection);
create__user_account($db_connection);
header("Contetnt-Type:applicatiob/json;charset=UTF-8");

$given_json  = json_decode(file_get_contents('php://input'));
$given_token = $given_json->token;
$number_of_matching_sessions = count_normal_user_sessions_by_token_match($db_connection, $given_token);

$json_output = new stdClass();

if ($number_of_matching_sessions == 0)
	{
	$json_output->msg="no such session with given token exists";
	$json_output->termination_state = 0;
	echo json_encode($json_output);
	die();
	}
	
if ($number_of_matching_sessions > 0)
	{
	remove__normal_user_session($db_connection, $given_token);
	$json_output->msg="session with given token exists; logging off";
	$json_output->termination_state = 1;
	echo json_encode($json_output);
	die();	
	}


?>