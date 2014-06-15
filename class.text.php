<?php 
	if(session_id() == '') {
	    // session_start();
	}

	$Text = new Text;
	
	/**
	* Text - multilanguage texts managing class
	* 
	* Responsible for managing texts.
	* Gets and inserts records into database table "texts".
	* Returns and defines text by given keyword.
	*
	*/
	class Text
	{
			

		private $texts;
		private $language = "";
		private $db;


		/**
		 * Initiates texts array, gets it from MySQL database
		 *
		 */
		function __construct()
		{
			include "dbConfig.php";
			$this->db = $db;
			if (!empty($_SESSION["user_language"])){
				$this->language = $_SESSION["user_language"];
			} else {
				$this->language = "en";
			}
			// $this->language = "en";
			$this->updateArray();
		}

		/**
		 * Changes texts language
		 *
		 * @param string $language 2 char language name
		 *
		 */
		function changeLanguage($language = "en"){
			$this->language = $language;
			$this->updateArray();
			$_SESSION["user_language"] = $language;
		}

		/**
		 * Clears texts array
		 *
		 */
		function clearArray(){
			unset($this->texts);
		}

		/**
		 * Updates texts array from MySQL database
		 *
		 */
		function updateArray(){ 
			$texts = $this->db->query("SELECT keyword, ".$this->language." as text FROM texts");
			if (!empty($texts)){
				foreach ($texts as $key => $value) {
					$this->texts[$value["keyword"]] = $value["text"];
				}
			}
		}

		/**
		 * Returns full language array. Identified by keyword
		 *
		 * @return query's results in array identified by keyword
		 *
		 */
		function getArray(){
			return $this->texts;
		}

		/**
		 * Returns text by given keyword if it exists
		 *
		 * @param string $keyword text keyword
		 * @return string single element from texts array
		 *
		 */
		function getText($keyword){
			if (empty($texts)){
				if (empty($this->texts[$keyword])){
					$this->addNewText($keyword);
				} 
				return $this->texts[$keyword];
			} else {
				return "text";
			}
		}

		/**
		 * Inserts new keyword into MySQL database without text
		 *
		 * @param string $keyword text keyword value
		 *
		 */
		function addNewText($keyword){
			$this->db->query("INSERT INTO texts (`keyword`, `".$this->language."`) VALUES ('".$keyword."', '".$keyword."');");
			$this->updateArray();
		}

	}

 ?>