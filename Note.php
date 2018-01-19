<?php
	class Note{
		private $noteId;
		private $userId;
		private $positionX;
		private $positionY;
		private $content;

		/*
		* Constructor
		*/
		function __construct($noteId = 0, $userId = 0, $positionX = 0, $positionY = 0, $content = ""){
			$this -> noteId = $noteId;
			$this -> userId = $userId;
			$this -> positionX = $positionX;
			$this -> positionY = $positionY;
			$this -> content = $content;
		}
		
		/*
		* get the note id
		*/
		function getNoteId(){
			return $this -> noteId;
		}
	
		/*
		* set the note id
		*/
		function setNoteId($noteId = 0){
			$this -> noteId = $noteId;
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
		* get x coordinate
		*/		
		function getPositionX(){
			return $this -> positionX;
		}
		
		/*
		* set x coordinate
		*/
		function setPositionX($positionX = 0){
			$this -> positionX = $positionX;
		}

		/*
		* get y coordinate
		*/
		function getPositionY(){
			return $this -> positionY;
		}
		
		/*
		* set y coordinate
		*/
		function setPositionY($positionY = 0){
			$this -> positionY = $positionY;
		}

		/*
		* get the content
		*/
		function getContent(){
			return $this -> content;
		}

		/*
		* set the content
		*/
		function setContent($content = ""){
			$this -> content = $content;
		}
	}
?>