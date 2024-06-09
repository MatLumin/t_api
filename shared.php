<?php
$db_server_host = "localhost";
$db_username = "root";
$db_password = "";

$name_of_db = "reactDB";
$name_of_table_for_contact_us = "contact_me_request";

$NAME_OF_TABLE__USER_SESSION = "normal_user_sesion"; //its in albanian
$NAME_OF_TABLE__USER_ACCOUNT = "perdorues_sesioni";
$NAME_OF_TABLE__PRICECARD_DATA = "te_dhenat_e_kartes_cmimit";


function connect_and_return_db($db_server_host, $db_username, $db_password)
	{
	$output = new mysqli($db_server_host, $db_username, $db_password);
	return $output;
	}


function create_db($db_connection)
	{
	$DB_CMD__CREATE_DB = "CREATE DATABASE IF NOT EXISTS {$GLOBALS['name_of_db']}";	
	$db_connection->query($DB_CMD__CREATE_DB);
	}
	
	
function use_db($db_connection)
	{
	$DB_CMD__USE_DB = "USE {$GLOBALS['name_of_db']}";
	$db_connection->query($DB_CMD__USE_DB);
	}	

//=====================================================
function create__contact_me__table($db_connection)
	{
	$DB_CMD__DEFINE_ITEM_TABLE = "
	CREATE TABLE IF NOT EXISTS {$GLOBALS['name_of_table_for_contact_us']}
		(
		id INT PRIMARY KEY AUTO_INCREMENT,
		name VARCHAR(200),
		email VARCHAR(200),
		subject VARCHAR(200),
		message VARCHAR(200)
		)
	";	
	$db_connection->query($DB_CMD__DEFINE_ITEM_TABLE);
	}


function insert__contact_me__item($db_connection, $name, $email, $subject, $message)
	{
	$db_connection->query
		(
		"
		INSERT INTO 
			{$GLOBALS['name_of_table_for_contact_us']}
			(name , email , subject, message) 
			VALUES 
			('{$name}', '{$email}', '{$subject}', '{$message}');
		"
		);
	}
//=============================================
function create__price_card_data($db_connection)
	{
	$db_connection->query
		(
		"
		CREATE TABLE IF NOT EXISTS {$GLOBALS['NAME_OF_TABLE__PRICECARD_DATA']}
			(
			id INT PRIMARY KEY AUTO_INCREMENT,
			title VARCHAR(64),
			price VARCHAR(64),
			days_to_do VARCHAR(64),
			text_1 VARCHAR(64),
			text_2 VARCHAR(64)
			);
		"
		);
	}
	
	
function get_all_price_cards_data($db_connection)
	{
	$result = $db_connection->query
		(
		"
		SELECT * FROM {$GLOBALS['NAME_OF_TABLE__PRICECARD_DATA']};
		"
		);
	
	$output = array();
	while ($row = $result->fetch_assoc())
		{
		array_push($output, $row);
		}
	return $output;		
	}
	
	
//=============================================
function create__normal_user_session__table($db_connection)
	{
	$db_connection->query
		(
		"
		CREATE TABLE IF NOT EXISTS {$GLOBALS['NAME_OF_TABLE__USER_SESSION']}
			(
			id INT PRIMARY KEY AUTO_INCREMENT,
			token VARCHAR(64),
			id_of_related_user int
			)
		"
		);
	}


function insert__normal_user_session($db_connection, $token, $id_of_related_user)
	{
	$db_connection->query
		(
		"
		INSERT INTO {$GLOBALS['NAME_OF_TABLE__USER_SESSION']}
			(
			token,
			id_of_related_user
			)
			VALUES
			(
			'{$token}',
			'{$id_of_related_user}'
			)
		"
		);
	}
	
	
function count_matches_of__normal_user_session__by_id($db_connection, $id_of_related_user)
	{
	$result = $db_connection->query
		(
		"SELECT COUNT(token) AS total FROM {$GLOBALS['NAME_OF_TABLE__USER_SESSION']}
		WHERE id_of_related_user='{$id_of_related_user}';
		"
		);
	$row = $result->fetch_assoc();
	return $row["total"];
	}	
	

function remove__normal_user_session($db_connection, $token)
	{
	$db_connection->query
		(
		"DELETE FROM {$GLOBALS['NAME_OF_TABLE__USER_SESSION']} WHERE token='{$token}'"
		);
	}
	
	
function get_token_of_normal_user_session_by_user_id($db_connection, $id_of_related_user)
	{
	$result = $db_connection->query
		(
		"SELECT token FROM {$GLOBALS['NAME_OF_TABLE__USER_SESSION']}
		WHERE id_of_related_user = {$id_of_related_user}" 
		);
	return $result->fetch_assoc()["token"];
	}
	
	
function count_normal_user_sessions_by_token_match($db_connection, $token)
	{
	$result = $db_connection->query
		(
		"
		SELECT COUNT(id) 
		AS total FROM {$GLOBALS['NAME_OF_TABLE__USER_SESSION']}
		WHERE token='{$token}'
		"
		);
	return $result ->fetch_assoc()["total"];
	}
//===========================================================================
function create__user_account($db_connection)
	{
	$db_connection->query
		(
		"
		CREATE TABLE IF NOT EXISTS {$GLOBALS['NAME_OF_TABLE__USER_ACCOUNT']}
			(
			id INT PRIMARY KEY AUTO_INCREMENT,
			username VARCHAR(200),
			password VARCHAR(200)
			)
		"
		);
	}
	
	
function count_number_of__user_account_by__username($db_connection, $useranme)
	{
	$result = $db_connection->query
		(
		"
		SELECT COUNT(id) AS total FROM {$GLOBALS['NAME_OF_TABLE__USER_ACCOUNT']}
		WHERE username='{$useranme}'
		"
		);	
	return ($result->fetch_assoc()["total"]);	
	}
	
	
	
	
function return_password_of__user_account__by_id($db_connection, $id)
	{
	$result = $db_connection->query
		(
		"
		SELECT password FROM {$GLOBALS['NAME_OF_TABLE__USER_ACCOUNT']} 
		WHERE id='{$id}'
		"
		);
	
	$row = $result->fetch_assoc();
	return $row["password"];
	}	
	
	
	
function return_id_of__user_account__by_username($db_connection, $username)
	{
	$result = $db_connection->query
		(
		"
		SELECT id FROM {$GLOBALS['NAME_OF_TABLE__USER_ACCOUNT']} 
		WHERE username='{$username}'
		"
		);
	
	$row = $result->fetch_assoc();
	return $row['id'];
	}

//=================================
function generate_rand_64_char_string()
	{
	$characters = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
	$output = "";
	for ($index=0; $index!=63; $index++)
		{
		$output .=  $characters[rand(0, strlen($characters)-1)];
		}
	return $output;
	}
?>