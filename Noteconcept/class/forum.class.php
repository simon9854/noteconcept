<?php
class Forum{
	private $_id;
	private $_idCat;
	private $_name;
	private $_description;
	private $_ordre;
	private $_lastPost;
	private $_nbTopic;
	private $_nbPost;
	private $_droit[];
	
	public function id(){return $this->_id;}
	public function idCat(){return $this->_idcat;}
	public function name(){return $this->_name;}
	public function description(){return $this->_description;}
	public function Ordre(){return $this->_ordre;}
	public function lastPost(){return $this->_lastPost;}
	public function nbTopic(){return $this->_nbTopic;}
	public function nbPost(){return $this->_nbPost;}
	
	public function __construct(){
	}
	
	
	
	
}
?>
