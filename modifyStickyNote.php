<?php
	/*
	* Called by script when changing coordinates of the sticky note.
	* Expects to receive the x and y coordinate and the note id
	*/
	require "DAO.php";
	
	//Check whether it was requested by POST
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		//Check noteId, positionx and positionY are set		
		if(isset($_POST['noteId']) & isset($_POST['positionX']) && isset($_POST['positionY']))
		{	
			$noteId = htmlentities(trim($_POST['noteId']));
			$positionX = htmlentities(trim($_POST['positionX']));
			$positionY = htmlentities(trim($_POST['positionY']));

			//Check correct data types			
			if(is_numeric($noteId) && is_numeric($positionX) && is_numeric($positionY)){
				//Updates the note with the specified x and y coordinates
				modifyNote($noteId, $positionX, $positionY);
			}
		}
	}

?>