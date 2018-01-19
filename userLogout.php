<?php
	/*
	* Called by script when user logs out.
	* Expects to receive the content and have started a session
	*/
	require "DAO.php";

	//Check whether it was requested by POST
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		session_start();
		session_unset();
		session_destroy();
	}

?>