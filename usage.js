

async function try_to_login(user_name, password)
	{
	let result = await fetch
		(
		"/try_to_login.php",
		method: "POST",
		headers : {"Content-Type":"application/json"},
		body : JSON.stringify({username:username, password:password})
		);
		
	let json_response = await result.json();
	let termination_state = json_response["termination_state"];
	
	let user_name_dows_not_exist = termination_state == 0;
	let password_is_wrong = termination_state == 1;
	let user_is_already_logged_in_and_its_ok = termination_state == 2;
	let things_are_ok = termination_state == 3;
	
	let token = json_response["token"];
	
	let message = json_response["msg"];
	
	}
	
	
	
async function try_to_logoff(token)
	{
	let result = await fetch
			(
			"/try_to_logoff.php",
			method: "POST",
			headers : {"Content-Type":"application/json"},
			body : JSON.stringify({token:token})
			);
	let json_response = await result.json();
	let termination_state = json_response["termination_state"];	
	
	let user_was_not_logged_in = termination_state == 0;
	let user_logged_of_sucessfully = termination_state == 1;
	
	let message = json_response["msg"];	
	}
	
	

async function is_logged_in(token)
	{
	let result = await fetch
			(
			"/is_token_valid.php",
			method: "GET",
			headers : {"Content-Type":"application/json"},
			body : JSON.stringify({token:token})
			);
	let json_response = await result.json();
	let termination_state = json_response["termination_state"];	
	
	let token_is_valid = termination_state == 1;
	let token_is_invaild = termination_state == 0;
	
	let message = json_response["msg"];
	}
	
	
	
async function add_contact_me()
	{
	let result = await fetch
			(
			"/create_contanct_me.php",
			method: "GET",
			headers : {"Content-Type":"application/json"},
			body : JSON.stringify
				({
				  first_name:"12345645",
				  last_name:"12345645",
				  email:"12345645",
				})
			);
	let response_text = await result.text();
	let is_ok = response_text == "200";
	}