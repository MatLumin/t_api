<?php


include "./shared.php"; 


$db_connection = connect_and_return_db($db_server_host, $db_username, $db_password);
create_db($db_connection);
use_db($db_connection);

create__normal_user_session__table($db_connection);
create__user_account($db_connection);
create__contact_me__table($db_connection);
?>