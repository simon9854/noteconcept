<?php

/*remarque amélioration de la classe et fonctionnement 
 * --utiliser la fonction hydrate lorsque l'on récupère les donnée d'un base de donnée
 * on vérifie les champs grace a la fonction de vérification les fonctions set n'ont donc pas besoin de vérifier si la valeur 
 * existe */
class Member{
	private $_id;
	private $_prenom;
	private $_nom;
	private $_age;
	private $_sexe;
	private $_pseudo;
	private $_avatar;
	private $_mdp;
	private $_ville;
	private $_pays;
	private $_adresse;
	private $_email;
	private $_web;
	private $_signature;
	private $_error;
	private $_droit;
	const REP_AVATAR = "./src/image-avatar/";
	
	const  BANNIS = 0000;
	const VISISTEUR = 0001;
	const USERS = 0010;
	const MODERATEUR = 0100;
	const ADMINISTRATEUR = 1111;
	
	/**/
	public function id(){ return $this->_id;}
	public function prenom(){return $this->_prenom;}
	public function nom(){return $this->_nom;}
	public function age(){return $this->_age;}
	public function sexe(){return $this->_sexe;}
	public function pseudo(){return $this->_pseudo;}
	public function avatar(){return $this->_avatar;}
	public function mdp(){return $this->_mdp;}
	public function ville(){return $this->_ville;}
	public function pays(){return $this->_pays;}
	public function adresse(){return $this->_adresse;}
	public function web(){return $this->_web;}
	public function signature(){return $this->_signature;}
	public function email(){return $this->_email;}
	public function error(){return $this->_error;}
	public function droit(){return $this->_droit;}
	
	public function statutDroit(){
		if($this->_droit == self::USERS){
			return "Utilisateur";
		}
		if($this->_droit == self::BANNIS){
			return "Bannis";
		}
	
		if($this->_droit == self::MODERATEUR){
			return "Moderateur";
		}
		if($this->_droit == self::ADMINISTRATEUR){
			return "Administrateur";
		}
	}
	

	public function hydrate(array $donnees){
		foreach($donnees as $key => $values){
			$method = 'set'.ucfirst($key);
			if(method_exists($this, $method)){
				$this->$method($values, $key);
			}
		}
	}
	
	public function __construct(){
	}
	
	public function setId($id){
		$id = (int)$id;
		$this->_id = $id;
	}
	
	//addError permet de sauvegarder les messages d'erreurs
	public function setPrenom($prenom){
	$msg = "";
		if (is_string($prenom))
		{	
			if(preg_match("/^[[:alpha:]]{2,20}$/",$prenom)){
				$this->_prenom = $prenom;
			}
			else{
				$this->_error++;
				$msg .= "<img src='src/image/ico-warning.gif' alt='erreur2'> le pr&eacute;nom ne peut contenir que des lettres.";
				return $msg;
			}
		}
		
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
	
	public function setAge($age){
	$msg="";
		$age = (int)$age;
		if(is_numeric($age)){
			if($age > 0 && $age < 120){
				$this->_age = $age;
			}
			else{
				$this->_error++;
				$msg .= "<img src='src/image/ico-warning.gif' alt='erreur2'> l'&acirc;ge doit &ecirc;tre compris entre 0 et 120.";
				return $msg;
			}
		}
	}
	
	public function setSexe($sexe){
			$this->_sexe = $sexe;
	}

	public function setPseudo($pseudo){
	$msg="";
		if (is_string($pseudo)){
			if (preg_match("/^[[:alnum:]]{4,15}$/",$pseudo)){
				$this->_pseudo = $pseudo;
			}
			else{
				$this->_error++;
				$msg .= "<img src='src/image/ico-warning.gif' alt='erreur2'> le pseudo doit &ecirc;tre compris entre 4 et 15 caract&egrave;res .";
				return $msg;
			}
		}
	}
	
	public function setAvatar($avatar){
		$this->_avatar = $avatar;
	}
	
	public function addAvatar(array $avatar){
		
		if(empty($avatar['name'])){$this->_avatar = 'no-avatar.png';}
		else{
			$msg="";
			$photo = new Image();
			$photo->__Photo($avatar['avatar']['name'], $avatar['avatar']['type'], $avatar['avatar']['size'], $avatar['avatar']['tmp_name']);
			if($photo->error() == ""){
				$photo->rename($this->_pseudo);
				if($photo->move_img(self::REP_AVATAR) == true){
					$this->_avatar = $photo->_name;
				}
				else{
					$this->_avatar = 'no-avatar.png';
					$msg = "<img src='src/image/ico-warning.gif' alt='erreur2'>erreur de chargement de l'image, une image par défault a &eacute;t&eacute; configur&eacute;";
					return $msg;
				}
			}else {
				$this->_error++;
				$msg .= "<img src='src/image/ico-warning.gif' alt='erreur2'>".$photo->error();
				return $msg;
				
			}
		}
		
		
	}
	
	public function testMdp($mdp, $confirm){
	$msg ="";
		if($mdp == $confirm){
			if(preg_match("/^[[:alnum:]]{4,10}$/",$mdp)){
				$this->_mdp = $mdp;
			}
			else {
				$this->_error++;
				$msg .= "<img src='src/image/ico-warning.gif' alt='erreur2'> le mot de passe doit comporter entre 4 et 10 caract&egrave;res";
			}
		}
		else{
			$this->_error++;
			$msg .= "<img src='src/image/ico-warning.gif' alt='erreur2'> le mot de passe est diff&eacute;rent de confirmer le mot de passe";
		}
		return $msg;
	}
	
	public function setMdp($mdp){
		$mdp = (string)$mdp;
			$this->_mdp = $mdp;
	
	
	}
	public function setVille($ville){
	$msg ="";
		if(is_string($ville)){
			if(preg_match("/^[[:alpha:]]{2,30}$/",$ville)){
				$this->_ville = $ville;
			}
		}
		else {
			$this->_error++;
			$msg .= "<img src='src/image/ico-warning.gif' alt='erreur2'> la ville ne peut contenir que des lettres ";
			return $msg;
		}
	}
	
	public function setPays($pays){
	$msg="";
		if(empty($pays)){
			$this->_pays= "none";
		}
		else {
				if(preg_match("/^[[:alpha:]]{2,80}$/",$pays)){
					$this->_pays= $pays;
				}
				else{
					$this->_error++;
					$msg .= "<img src='src/image/ico-warning.gif' alt='erreur2'> le pays ne peut contenir que des lettres ";
					return $msg;
				}
			}	
	} 
	
	public function setAdresse($adresse){
	$msg="";
		if(!empty ($adresse)){
				if(preg_match("/^([0-9a-zA-Z'àâéèêôùûçÀÂÉÈÔÙÛÇ\s-]{1,50})$/", $adresse)){
					$this->_adresse = $adresse;
				}
				else {
					$this->_error++;
					$msg .= "<img src='src/image/ico-warning.gif' alt='erreur2'> Erreur de format adresse";
				}
			}
			else $this->_adresse = "none";
	}
	
	public function setEmail($email){
	$msg="";
		if (is_string($email)){
			if (preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $email))
			{
				$this->_email = $email;
			}
			else {
				$this->_error++;
				$msg.="<img src='src/image/ico-warning.gif' alt='erreur2'> L\'adresse ' .$email. ' n\'est pas valide, recommencez !";	
			}
		}
		
	}
	
	public function setWeb($web){
		if(empty($web)) $this->_web = "none";
		else{
			$web = (string) $web;
			$this->_web = $web;
		}
	}
	
	public function setSignature($signature){
		$msg="";
		if(empty($signature))	$this->_signature = "none";
		else{
			if(strlen($signature) < 200){
				$this->_signature = $signature;
			}
			else{
				$this->_error++;
				$msg .= "<img src='src/image/ico-warning.gif' alt='erreur2'> une signature ne peut contenir plus de 200 caract&egrave;re ";
				return $msg;
			}
		}
	}
	public function setDroit($droit){
		$droit = (int)$droit;
		$this->_droit = $droit;
		
	}
	public function testMember(array $donne){
		$message_new ="";
		foreach ($donne as $field => $value)
		{
			if ($field != "signature" and $field !="website" and $field !="adresse")
			{
				if ($value == "")
				{
					$blank[] = $field;
				}
			}
			if (isset($blank))
			{
				$message_new ="champs non saisis, veuillez les renseigner: ";
				foreach($blank as $value)
				{
					$message_new .= " $value, ";
				}
				extract($_POST);
			}	
		}
		return $message_new;
	}
	
}

?>