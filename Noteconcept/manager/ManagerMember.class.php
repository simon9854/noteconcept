
<?php 
class ManagerMember{
	private $_db;
	private $_message;
	
	public function __construct(PDO $db){
		$this->setDb($db);
	}
	
	public function verifMember($pseudo, $email){
		$q = $this->_db->query('SELECT pseudo, email FROM member');
		$donne = $q->fetch(PDO::FETCH_ASSOC);
		if(empty ($donne)){
			return 0;
		}
		else {
			foreach($donne as $values){
				if($values == $pseudo or $values == $email) return 1;
				else return 0;
			}	
		}
	}
	
	public function addMember(Member $perso){
			if($this->verifMember($perso->pseudo(), $perso->email()) == 0){
				$q = $this->_db->prepare('INSERT INTO member SET nom = :nom, prenom = :prenom, age = :age, sexe = :sexe, pseudo = :pseudo,
				avatar = :avatar, mdp = :mdp, ville = :ville, pays = :pays, adresse = :adresse, email = :email, web = :web, signature = :signature, date_create = :date, droit=:droit');
				try{
					$q->bindValue(':nom', $perso->nom(), PDO::PARAM_STR);
					$q->bindValue(':prenom', $perso->prenom(), PDO::PARAM_STR);
					$q->bindValue(':age', $perso->age(), PDO::PARAM_INT);
					$q->bindValue(':sexe', $perso->sexe(), PDO::PARAM_STR);
					$q->bindValue(':pseudo', $perso->pseudo(), PDO::PARAM_STR);
					$q->bindValue(':avatar', $perso->avatar(), PDO::PARAM_STR);
					$q->bindValue(':mdp', $perso->mdp(), PDO::PARAM_STR);
					$q->bindValue(':ville', $perso->ville(), PDO::PARAM_STR);
					$q->bindValue(':pays', $perso->pays(), PDO::PARAM_STR);
					$q->bindValue(':adresse', $perso->adresse(), PDO::PARAM_STR);
					$q->bindValue(':email', $perso->email(), PDO::PARAM_STR);
					$q->bindValue(':web', $perso->web(), PDO::PARAM_STR);
					$q->bindValue(':signature', $perso->signature(), PDO::PARAM_STR);
					$q->bindValue(':date', date("Y-m-d H:i:s"), PDO::PARAM_STR);
					$q->bindValue(':droit', 0010, PDO::PARAM_INT);
					if($q->execute()){
						$this->_message =  "le membre à bien été crée.";
					}
				}
					catch (Exception $e){
						$this->_message = $e->getMessage();
					}
			}
			else echo "<img src='./src/image/Error.png' alt='erreur pseudo' class='img_errorH'> Le pseudo est d&eacute;j&agrave; utilis&eacute; veuillez saissir un autre.";
	}
	public function deleteMeber(Member $perso){
		$this->_db->exec('DELETE FROM member WHERE id ='.$perso->id());
		
	}
	public function getId($id){
		$id = (int)$id;
		$q = $this->_db->query('SELECT * FROM member WHERE id = '.$id.'');
		$donnees = $q->fetch(PDO::FETCH_ASSOC);
		$perso = new Member();
		$perso->hydrate($donnees);
		return $perso;
	}
	public function getList(){
		$membre = array();
		$q = $this->_db->query('SELECT * FROM member ORDER BY pseudo');
		
		while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
		{
			$perso = new Member();
			$membre[] = $perso->hydrate($donnees);
		}
		return $membre;
		
	}
	public function updateMember(Member $perso){
		
		$q = $this->_db->prepare('UPDATE member SET prenom = :prenom, nom = :nom, age = :age, sexe = :sexe, pseudo = :pseudo,
				avatar = :avatar, mdp = :mdp, ville = :ville, pays = :pays, adresse = :adresse, email = :email, web = :web, signature = :signature, droit = :droit WHERE id = :id');
		
		try{
			$q->bindValue(':prenom', $perso->prenom(), PDO::PARAM_STR);
			$q->bindValue(':nom', $perso->nom(), PDO::PARAM_STR);
			$q->bindValue(':age', $perso->age(), PDO::PARAM_INT);
			$q->bindValue(':sexe', $perso->sexe(), PDO::PARAM_INT);
			$q->bindValue(':pseudo', $perso->pseudo(), PDO::PARAM_STR);
			$q->bindValue(':avatar', $perso->avatar(), PDO::PARAM_STR);
			$q->bindValue(':mdp', $perso->mdp(), PDO::PARAM_STR);
			$q->bindValue(':ville', $perso->ville(), PDO::PARAM_STR);
			$q->bindValue(':pays', $perso->pays(), PDO::PARAM_STR);
			$q->bindValue(':adresse', $perso->adresse(), PDO::PARAM_STR);
			$q->bindValue(':email', $perso->email(), PDO::PARAM_STR);
			$q->bindValue(':web', $perso->web(), PDO::PARAM_STR);
			$q->bindValue(':signature', $perso->signature(), PDO::PARAM_STR);
			$q->bindValue(':droit', $perso->droit(), PDO::PARAM_INT);
			$q->bindValue(':id', $perso->id(), PDO::PARAM_INT);
			if($q->execute()){
				$this->_message =  "<span class = 'message_valid'>le membre ". $perso->pseudo() ." à bien été mise à jour.</span>";
			}
		}
		catch (Exception $e){
			$this->_message = "<span class='message_errorH'><img src='./src/image/Error.png' alt='erreur mise à jour' class='img_errorH'>".$e->getMessage()."</span>";
		}
		
	}
	
	public function connect($pseudo, $mdp){
		$q = $this->_db->query('SELECT COUNT(*) FROM member WHERE pseudo = "'.$pseudo.'"');
		$count = $q->fetch(PDO::FETCH_ASSOC);
		if($count['COUNT(*)'] > 0){
			$q = $this->_db->query('SELECT id FROM member WHERE pseudo = "'.$pseudo.'" AND mdp = "'.$mdp.'"');
			$donnees = $q->fetch(PDO::FETCH_ASSOC);
			if($donnees != NULL){
				return $donnees['id'];
			}
			else {
				$this->_message = "<span class='message_errorH'><img src='./src/image/Error.png' alt='erreur mot de passe' class='img_errorH'>Le mot de passe est incorrecte</span>";
				return -1;
			}
		}
		else{ 
			$this->_message = "<span class='message_errorH'><img src='./src/image/Error.png' alt='erreur pseudo' class='img_errorH'>Le pseudo ".$pseudo." est introuvable </span>";
			return -1;
		}
	}
	
	public function desconnect(){
		if(isset($_SESSION['member'])){
			session_destroy();
		}
	}
	
	public function message(){
		return $this->_message;
	}
	
	public function getMessage(){ 
		$msg = $this->_message;
		$this->_message = "";
		return $msg;
		
	}
	
	public function setDb(PDO $db){
		$this->_db = $db;
	}
}

?>