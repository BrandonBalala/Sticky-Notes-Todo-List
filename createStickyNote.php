<?php
	/*
	* Called by script when creating a sticky note.
	* Expects to receive the content and have started a session
	*/
	require "DAO.php";
	
	//Check whether it was requested by POST
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		//Start session
		session_start();
		
		//Check content and userId are set
		if(isset($_POST['content']) && isset($_SESSION['userId']))
		{	
			$content = htmlentities(trim($_POST['content']));
			$userId = $_SESSION['userId'];

			//Check correct data types
			if(is_string($content) && is_numeric($userId)){
				//Create a note and get the note id of the last inserted row
				$noteid = createtNote($userId, $content);
				
				//Get all notes by user id
				$result = getNotesByUserId($userId);
				
				//JSON encode and returns it to invoking script
				echo json_encode($result);
			}
		}
	}

?>