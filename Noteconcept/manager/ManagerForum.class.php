<?php 
class ManagerForum{
	private $_db;
	private $_message;
	
	public function __construct(PDO $db){
		$this->setDb($db);
	}
	
	public function setDb(PDO $db){
		$this->_db = $db;
	}
	
	/*function pour les catégorie*/
	
	public function createCat(Categorie $cat){
		
	}
	
	public function updateCat(){
		
	}
	
	public function deleteCat(Categorie $cat){
		
	} 
	
	public function selectAllCat(){}
	
	public function selectCat(){}
	
	/*function pour le forum*/
	
	public function createForum(Forum $forum){
	
	}
	
	public function updateForum(){
	
	}
	
	public function deleteForum(Forum $forum){
	
	}
	
	public function selectAllForum(){}
	
	public function selectForum(){}
	
}

?>