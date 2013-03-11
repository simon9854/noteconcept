<?php
class Categorie{
	protected $_id;
	private $_nom;
	protected $_ordre;
	private $_error;
	
	public function __construct(){}
	
	public function id(){return $this->_id;}
	public function nom(){return $this->_nom;}
	public function ordre(){return $this->_ordre;}
	public function error(){return $this->_error;}
	
	public function setId($id){
		$id = (int)$id;
		$this->_id = $id;
	}
	
	public function setNom($nom){
		$msg ="";
		if (is_string($nom))
		{
			if(preg_match("/^[A-z ]{2,20}$/",$nom)){ //rechercher regex pour le nom de famille
				$this->_nom = $nom;
			}
			else {
				$this->_error++;
				$msg .="<img src='src/image/ico-warning.gif' alt='erreur2'> le nom ne peut contenir que des lettres.";
				return $msg;
			}
		}
	}
	
	public function setOrdre($ordre){
		$ordre = (int)$ordre;
		$this->_ordre = $ordre;
		
	}
}
?>