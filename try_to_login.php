<?php 
include "./shared.php"; 

$given_json  = json_decode(file_get_contents('php://input'));

$db_connection = connect_and_return_db($db_server_host, $db_username, $db_password);
create_db($db_connection);
use_db($db_connection);

create__normal_user_session__table($db_connection);
create__user_account($db_connection);

header("Contetnt-Type:applicatiob/json;charset=UTF-8");


$given_json  = json_decode(file_get_contents('php://input'));

$given_username = $given_json->username;
$given_password = $given_json->password;

$json_output = new stdClass();

$username_matches_count = count_number_of__user_account_by__username($db_connection, $given_username);

if ($username_matches_count == 0)	
	{
	$json_output->termination_state = 0;
	$json_output->msg = "username does not exist";
	echo(json_encode($json_output));
	die();
	}


$id_of_user = return_id_of__user_account__by_username($db_connection, $given_username, $given_password);
$password =  return_password_of__user_account__by_id($db_connection, $id_of_user);

if ($password != $given_password)
	{
	$json_output->termination_state = 1;
	$json_output->msg = "password is wrong";
	echo(json_encode($json_output));
	die();
	}
	
	
$user_sessions_mathings_gievn_id = count_matches_of__normal_user_session__by_id($db_connection, $id_of_user);	
if ($user_sessions_mathings_gievn_id != 0)
	{
	$token = get_token_of_normal_user_session_by_user_id($db_connection, $id_of_user);
	$json_output->termination_state = 2;
	$json_output->msg = "user-session exists for this user so we are returning the old token for it";
	$json_output->token = $token;
	echo(json_encode($json_output));
	die();		
	}


if ($password == $given_password)
	{
	$token = generate_rand_64_char_string();
	insert__normal_user_session($db_connection, $token, $id_of_user,);	
	$json_output->termination_state = 3;
	$json_output->token = $token;
	$json_output->msg = "password is right; logged the user";
	echo(json_encode($json_output));
	die();
	}

?>