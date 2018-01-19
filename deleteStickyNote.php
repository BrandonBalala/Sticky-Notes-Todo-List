<?php
	/*
	* Called by script when deleting a sticky note.
	* Expects to have a note id
	*/
	require "DAO.php";
	
	//Check whether it was requested by POST
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		
		//Check userId are set
		if(isset($_POST['noteId']))
		{	
			$noteId = htmlentities(trim($_POST['noteId']));
			
			//Check correct data types
			if(is_numeric($noteId)){
				//Delete and gets the row deleted
				$rowDeleted = deleteNoteById($noteId);
				
				//Return row deleted to invoking script
				echo $rowDeleted;
			}
		}
	}

?>