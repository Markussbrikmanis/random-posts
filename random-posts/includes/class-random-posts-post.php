<?php
/**
 * Post object
 *
 * @package    Random_Posts
 * @subpackage Random_Posts/includes
 * @author     Markuss Brikmanis <markussbrikmanis@gmail.com>
 */

if(!class_exists('Random_Posts_Post')){
	class Random_Posts_Post {
		private $userID;
		private $ID;
		private $title;
		private $body;
		private $img;

		public function __construct($userID, $ID, $title, $body, $img = "https://images.unsplash.com/photo-1686995309003-9a141da8a6e6?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1172&q=80")
		{
			$this->userID = $userID;
			$this->ID = $ID;
			$this->title = $title;
			$this->body = $body;
			$this->img = $img;
		}

		/**
		 * Get the value of userID
		 */ 
		public function getUserID()
		{
			return $this->userID;
		}

		/**
		 * Set the value of userID
		 *
		 * @return  self
		 */ 
		public function setUserID($userID)
		{
			$this->userID = $userID;

			return $this;
		}

		/**
		 * Get the value of ID
		 */ 
		public function getID()
		{
			return $this->ID;
		}

		/**
		 * Set the value of ID
		 *
		 * @return  self
		 */ 
		public function setID($ID)
		{
			$this->ID = $ID;

			return $this;
		}

				/**
		 * Get the value of title
		 */ 
		public function getTitle()
		{
			return $this->title;
		}

		/**
		 * Set the value of title
		 *
		 * @return  self
		 */ 
		public function setTitle($title)
		{
			$this->title = $title;

			return $this;
		}

		/**
		 * Get the value of body
		 */ 
		public function getBody()
		{
			return $this->body;
		}

		/**
		 * Set the value of body
		 *
		 * @return  self
		 */ 
		public function setBody($body)
		{
			$this->body = $body;

			return $this;
		}
		/**
		 * Get the value of img
		 */ 
		public function getImg()
		{
			return $this->img;
		}

		/**
		 * Set the value of img
		 *
		 * @return  self
		 */ 
		public function setImg($img)
		{
			$this->img = $img;

			return $this;
		}

	}


	
}