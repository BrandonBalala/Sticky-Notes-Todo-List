<?php 
	require "Note.php";
	require "User.php";
	$host = "localhost";
	$user = "root";
	$password = "";
	$dbname = "assignment2";
	
	/*
	* Function that takes care of creating a user into the database
	* with the specified username and password
	*/
	function createUser($username, $userPassword){
		global $host, $user, $password, $dbname;

		try {
			$pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);

			$query = "INSERT INTO user(username, password) 
					VALUES(?,?);";

			$stmt = $pdo -> prepare($query);
					
			$stmt -> bindParam(1, $username);
			$stmt -> bindParam(2, $userPassword);
			
			$stmt -> execute();
			
			//returns the last insert id in user table
			return $pdo -> lastInsertId('userId');
		} catch (PDOException $e) {
			echo $e -> getMessage();
			return -1;
		} finally{
			unset ($pdo);
		}
	}
	
	/*
	* Function that inserts a new note in the database
	* with the following user id and content
	*/
	function createtNote($userid, $content){
		global $host, $user, $password, $dbname;
		
		try {
			$pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);

			$query = "INSERT INTO note(CONTENT, USERID) 
					VALUES(?,?);";

			$stmt = $pdo -> prepare($query);
					
			$stmt -> bindParam(1, $content);
			$stmt -> bindParam(2, $userid);
			
			$stmt -> execute();
			
			//returns the last insert id in note table
			return $pdo -> lastInsertId('noteid');
		} catch (PDOException $e) {
			echo $e -> getMessage();	
		} finally{
			unset ($pdo);
		}
	}

	/*
	* Function that gets the user and all its properties
	* with the defined user id
	*/	
	function getUserByUserId($userId){
		global $host, $user, $password, $dbname;
		
		try {
			$pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);

			$query = "SELECT userId, username, password, login_attempts, timeout FROM user
					WHERE userId = ?;";
				
			$stmt = $pdo -> prepare($query);
					
			$stmt -> bindParam(1, $userId);
			
			$stmt -> execute();

			$stmt ->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'User');
			
			$response = null;
			if($row = $stmt -> fetch())
			{
			    $respRow["userId"] = $row -> getUserId();
			    $respRow["username"] = $row -> getUsername();
			    $respRow["password"] = $row -> getPassword();
				$respRow["login_attempts"] = $row -> getLoginAttempts();
				$respRow["timeout"] = $row -> getTimeout();
				
			    $response[] = $respRow;
			}
	
			//returns the user that was found and all necessary properties if it exists
			//else it returns null
			return $response;
		} catch (PDOException $e) {
			echo $e -> getMessage();	
		} finally{
			unset ($pdo);
		}
	}

	/*
	* Function that gets the user
	* with the defined username
	*/		
	function getUserByUsername($username){
		global $host, $user, $password, $dbname;
		
		try {
			$pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);

			$query = "SELECT userId, username, password, login_attempts, timeout FROM user
					WHERE username = ?;";
				
			$stmt = $pdo -> prepare($query);
					
			$stmt -> bindParam(1, $username);
			
			$stmt -> execute();

			$stmt ->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'User');
			
			$response = null;
			if($row = $stmt -> fetch())
			{
			    $respRow["userId"] = $row -> getUserId();
			    $respRow["username"] = $row -> getUsername();
			    $respRow["password"] = $row -> getPassword();
				$respRow["login_attempts"] = $row -> getLoginAttempts();
				$respRow["timeout"] = $row -> getTimeout();
				
			    $response[] = $respRow;
			}
			
			//returns the user that was found and all necessary properties if it exists
			//else it returns null
			return $response;
		} catch (PDOException $e) {
			echo $e -> getMessage();	
		} finally{
			unset ($pdo);
		}
	}
	
	/*
	* Function that gets all the notes
	* with the specified user id
	*/
	function getNotesByUserId($userid){
		global $host, $user, $password, $dbname;
		
		try {
			$pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);

			$query = "SELECT noteId, userId, content, positionX, positionY FROM note
					WHERE userId = ?;";
				
			$stmt = $pdo -> prepare($query);
					
			$stmt -> bindParam(1, $userid);
			
			$stmt -> execute();

			$stmt ->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'Note');
			
			$response = null;
			while($row = $stmt -> fetch())
			{
			    $respRow["noteId"] = $row -> getNoteId();
			    $respRow["userId"] = $row -> getUserId();
				$respRow["contents"] = $row -> getContent();
				$respRow["positionX"] = $row -> getPositionX();
				$respRow["positionY"] = $row -> getPositionY();
				
			    $response[] = $respRow;
			}
			
			//returns all the notes that were found and all necessary properties if it exists
			//else it returns null
			return $response;

		} catch (PDOException $e) {
			echo $e -> getMessage();	
		} finally{
			unset ($pdo);
		}
	}

	/*
	* Function that deletes a note
	* with the specified note id
	*/	
	function deleteNoteById($noteid){
		global $host, $user, $password, $dbname;

		try {
			$pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);

			$query = "DELETE FROM note
					WHERE noteId = ?;";
				
			$stmt = $pdo -> prepare($query);
					
			$stmt -> bindParam(1, $noteid);
			
			$stmt -> execute();
			
			//Get number of rows affected
			$count = $stmt -> rowCount();
			
			//returns the note id of the note that was deleted
			//else returns -1
			if($count >= 1)
				return $noteid;
			else
				return -1;
		} catch (PDOException $e) {
			echo $e -> getMessage();	
		} finally{
			unset ($pdo);
		}
	}
	
	/*
	* Function that updates the X and Y coordinates of the sticky notes
	* with the specified note id
	*/
	function modifyNote($noteid, $positionX, $positionY){
		global $host, $user, $password, $dbname;

		try {
			$pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);

			$query = "UPDATE note
					SET positionX = ?, positionY = ?
					WHERE noteId = ?;";
				
			$stmt = $pdo -> prepare($query);
			
			$stmt -> bindParam(1, $positionX);
			$stmt -> bindParam(2, $positionY);
			$stmt -> bindParam(3, $noteid);
			
			$stmt -> execute();
		} catch (PDOException $e) {
			echo $e -> getMessage();	
		} finally{
			unset ($pdo);
		}
	}

	/*
	* Function that modifies a users login attempts and his timeout
	*/
	function modifyUser($userId, $login_attempts, $timeout){
		global $host, $user, $password, $dbname;

		try {
			$pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);

			$query = "UPDATE user
					SET login_attempts = ?, timeout = ?
					WHERE userId = ?;";
				
			$stmt = $pdo -> prepare($query);
			
			$stmt -> bindParam(1, $login_attempts);
			$stmt -> bindParam(2, $timeout);
			$stmt -> bindParam(3, $userId);
			
			$stmt -> execute();
		} catch (PDOException $e) {
			echo $e -> getMessage();	
		} finally{
			unset ($pdo);
		}
	}	

?>