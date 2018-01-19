<?php
	/*
	* Called by script when attempting to log into the database.
	* Expects to receive the content and have started a session
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
				
				//gets the user by the username, returns one set of result if found
				//else would return null
				$result = getUserByUsername($username);
				
				
				if(!is_null($result)){
					$userId = $result[0]['userId'];
					$passwordResult = $result[0]['password'];
					$login_attempts = $result[0]['login_attempts'];
					$timeout = $result[0]['timeout'];
					$formatted_current_timestamp = date("Y-m-d H:i:s", strtotime("now"));
			
					$goodPW = false;
					
					//Check that the password matches the hashed password
					if(password_verify($userPassword, $passwordResult))
						$goodPW = true;

					if(!$goodPW){
						//Increments the login attempts
						$increment = $login_attempts + 1;
						
						if($login_attempts < 2){ //If smaller than 3 failed attempts
							//Add one to attempts
							modifyUser($userId, $increment, null);
							echo 1; //wrong password
						}
						else if($login_attempts == 2){ //If failed 3 times 
							$formattedDate = date("Y-m-d H:i:s", strtotime("+30 minutes", strtotime("now")));
							//Add one to attempts and adds a timeout
							modifyUser($userId, $increment, $formattedDate);
							echo 2; //to many bad attempts, try again in 30 minutes
						}
					}
					else{
						//Checks whether it has a timeout or not
						if(!is_null($timeout)){ //time out is null
							if($formatted_current_timestamp < $timeout)
								echo 3; //account blocked for 30 minutes
							else{ //timeout not null
								//Resets the timeout and the attempts
								modifyUser($userId, 0, null);
								startSession($userId, $username);
							}
						}
						else{
							//Resets the timeout and the attempts
							modifyUser($userId, 0, null);
							startSession($userId, $username);
						}
					}
				}
				else
					echo 0; //username does not exist
			}
		}
	}
	
	/*
	* Function that starts a new session
	*/
	function startSession($userId, $username){
		session_start();
		$_SESSION['userId'] = $userId;
		$_SESSION['username'] = $username;
		session_regenerate_id();
		echo 4; //perfect can log in
	}
?>