<?php
class Secure
{
	private $_Limit;
	private $_limitTime;
	
	public function __construct($limit, $times){
		$this->_Limit = $limit;
		$this->_limitTime = $times;
	}
	
	public function limit(){
		return $this->_Limit;
	}
	public function limitTime(){
		return $this->limitTime();
	}
	
	
	// Données entrantes
	public static function bdd($string)
	{
		// On regarde si le type de string est un nombre entier (int)
		if(ctype_digit($string))
		{
			$string = intval($string);
		}
		// Pour tous les autres types
		else
		{
			$string = mysql_real_escape_string($string);
			$string = addcslashes($string, '%_');
		}

		return $string;

	}
	// Données sortantes
	public static function html($string)
	{
		return htmlentities($string);
	}
}
?>