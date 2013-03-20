<?php
class Categorie{
	protected $_id;
	private $_nom;
	protected $_ordre;
	private $_error;
	
	public function __construct(){}
	
	public function hydrate(array $donnees){
		foreach($donnees as $key => $values){
			$method = 'set'.ucfirst($key);
			if(method_exists($this, $method)){
				$this->$method($values, $key);
			}
		}
	}
	
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
		if(!empty($nom)){
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
		}else $this->_error++;
	}
	
	public function setOrdre($ordre){
		if(!empty($ordre)){
			$ordre = (int)$ordre;
			$this->_ordre = $ordre;
		}else $this->_error++;
		
	}
}
?>