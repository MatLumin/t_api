<?php
include "./shared.php"; 

$db_connection = connect_and_return_db($db_server_host, $db_username, $db_password);
create_db($db_connection);
use_db($db_connection);

create__price_card_data($db_connection);

$given_json  = json_decode(file_get_contents('php://input'));

header("Contetnt-Type:applicatiob/json;charset=UTF-8");

$json_output = array();

$all_price_cards = get_all_price_cards_data($db_connection);



for ($index = 0; $index!=count($all_price_cards); $index++)
	{
	$sub_out = new stdClass();
	$sub_out->id=$all_price_cards[$index]["id"];
	$sub_out->title=$all_price_cards[$index]["title"];
	$sub_out->price=$all_price_cards[$index]["price"];
	$sub_out->days_to_do=$all_price_cards[$index]["days_to_do"];
	$sub_out->text_1=$all_price_cards[$index]["text_1"];
	$sub_out->text_2=$all_price_cards[$index]["text_2"];
	array_push($json_output, $sub_out);
	}

echo(json_encode($json_output));
die();

?>