<?php
	/*
	* Called by script when retrieving all sticky note of specific user.
	* Expects to have started a session
	*/
	require "DAO.php";

	//Check whether it was requested by POST
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		session_start();
		
		//Check userid is set
		if(isset($_SESSION['userId'])){
			$userId = $_SESSION['userId'];
			
			//Get all notes by user id
			$result = getNotesByUserId($userId);
			
			//JSON encode and returns it to invoking script
			echo json_encode($result);
		}
	}

?>