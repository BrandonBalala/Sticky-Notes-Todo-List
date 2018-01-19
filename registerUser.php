<?php
	/*
	* Called by script when registering.
	* Expects to receive a username and password
	*/
	require "DAO.php";
	
	//Check whether it was requested by POST
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		
		//Check username and password are set
		if(isset($_POST['username']) && isset($_POST['password']))
		{	
			$username = htmlentities(trim($_POST['username']));
			$userPassword = htmlentities(trim($_POST['password']));
			
			//Check correct data types			
			if(is_string($username) && is_string($userPassword)){
				//Hash the password
				$hashed = password_hash($userPassword, PASSWORD_DEFAULT);
				//Insert user in user table
				$userId = createUser($username, $hashed);
				
				//Returns the last inserd id 
				//else a -1 which specifies an error or either user name is already in use
				echo $userId;
			}
		}
	}
?>