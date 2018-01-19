<?php
	class User{
		private $userId;
		private $username;
		private $password;
		private $login_attempts;
		private $timeout;
		
		/*
		* Constructor
		*/
		function __construct($userId = 0, $username = "", $password = "", $login_attempts = 0, $timeout = ""){
			$this -> userId = $userId;
			$this -> username = $username;
			$this -> password = $password;
			$this -> login_attempts = $login_attempts;
			$this -> timeout = $timeout;
		}
		
		/*
		* get the user id
		*/
		function getUserId(){
			return $this -> userId;
		}

		/*
		* set the user id
		*/		
		function setUserId($userId = 0){
			$this -> userId = $userId;
		}

		/*
		* get the username
		*/		
		function getUsername(){
			return $this -> username;
		}

		/*
		* set the username
		*/			
		function setUsername($username = ""){
			$this -> username = $username;
		}

		/*
		* get the password
		*/
		function getPassword(){
			return $this -> password;
		}

		/*
		* set the password
		*/		
		function setPassword($password = ""){
			$this -> password = $password;
		}

		/*
		* get the login attempts
		*/		
		function getLoginAttempts(){
			return $this -> login_attempts;
		}

		/*
		* set the login attempts
		*/	
		function setLoginAttempts($login_attempts = 0){
			$this -> login_attempts = $login_attempts;
		}

		/*
		* get the timeout
		*/		
		function getTimeout(){
			return $this -> timeout;
		}
		
		/*
		* set the timeout
		*/	
		function setTimeout($timeout = ""){
			$this -> timeout = $timeout;
		}		
	}
?>