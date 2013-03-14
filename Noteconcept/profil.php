<?php
session_start();
include('include/constante.inc.php');
include_once('include/autochargement.inc.php');
include('include/use.inc.php');
$action = isset($_GET['action'])?htmlspecialchars($_GET['action']):'consulter';

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
<title>Profil</title>
<link rel="stylesheet" type="text/css" href="src/css/design.css">
<link rel="stylesheet" type="text/css" href="src/css/menuUsers.css">
</head>
<body>
	<?php
	include('include/header.inc.php');
	if(isset($_GET['m']) && $_GET['m'] != -1){
		$id = $_GET['m'];
		// permet de voir le profil d'un utilisateur lambda (perso2 est la personne que l'on regarde)
		$perso2 = $manager->getId($id);
		if($_SESSION['id'] == $id){
			include('include/menuUsers.inc.php');
			echo"<div class='corpProfil'>";
			echo "<h2 class='HeadProfil'>Profil de ".$perso->pseudo()."</h2>";
		}else{
			echo "<h2 class='HeadProfil'>Profil de ".$perso2->pseudo()."</h2>";
			echo"<div class='corpProfil'>";
		}
		switch ($action){
			case "consulter":
				echo "<img src='src/image-avatar/".$perso2->avatar()."' width='120px' height='120px'>";
				echo "<p>Nom : ".$perso2->nom()."\n
				Prénom : ".$perso2->prenom()." \t
				âge : ".$perso2->age()."
				Sexe : ".$perso2->sexe()."
				Pseudo : ".$perso2->pseudo()."
				Adresse : ".$perso2->adresse()."
				Pays : ".$perso2->pays()."
				Ville : ".$perso2->ville()."
				Email : ".$perso2->email()."
				Web : ".$perso2->web()."
				Signature : ".$perso2->signature()."</p>";
				

			break;
			case "modif":
				if($_SESSION['id'] == $perso->id()){
					
					if(isset ($_GET['check']) and !empty ($_POST)){
						$msg = $perso->testMember($_POST);
						if($msg != ""){
							echo"<span class='message_error'><img src='src/image/ico-close.gif' alt='erreur' id='img-erreur'> ";
							echo"$msg". "ou le mot de passe diff&eacute;rent de la confirmation. </span>";
						}
					}
					
					echo "<form method='POST' action='profil.php?m=".$_SESSION ['id']."&amp;action=modif&amp;check=1' enctype='multipart/form-data' id='FormUser'>
					<fieldset><legend>Identifiants</legend>
					<label for='sexe' class='form_col'>* Sexe :</label><select name='sexe'>
					<option value='M'>Homme</option>
					<option value='F'>Femme</option>
					</select>";
					?>
					<span class="verif_form"><?php if(isset ($_GET['check'])) echo $perso->setSexe($_POST['sexe']);  ?> </span><br>
					<label for="loginName" class='form_col'>* Pseudo :</label><input name="pseudo" type="text" maxlength = "40" value="<?php echo $perso->pseudo();  ?>" />
					<span class="verif_form"><?php if(isset ($_GET['check'])){ echo $perso->setPseudo($_POST['pseudo']); }  ?></span><br>
					<label for="age" class='form_col'>*&acirc;ge</label><input name="age" type="number" maxlength = "3" value="<?php echo $perso->age();?>" />
					<span class="verif_form"><?php if(isset ($_GET['check'])){ echo  $perso->setAge($_POST['age']); }  ?></span><br>
					<label for="pass" class='form_col'>* Mot de Passe :</label><input type="password" name="mdp" maxlength = "40" value="<?php echo $perso->mdp(); ?>" />
					<span class="verif_form"><?php if(isset ($_GET['check'])){ echo $perso->testMdp($_POST['mdp'], $_POST['mdp_confirm']); }  ?></span><br>
					<label for="confirm" class='form_col'>*Confirmer le mot de passe :</label><input type="password" name="mdp_confirm" maxlength = "40" value="<?php echo $perso->mdp(); ?>" />
					<br>
					<label for="lastname" class='form_col'>* Nom :</label><input type="text" name="nom" maxlength = "40"  value="<?php echo $perso->nom(); ?>" /></input>
					<span class="verif_form"><?php if(isset ($_GET['check'])){ echo $perso->setNom($_POST['nom']); }  ?></span><br>
					<label for="firstName" class='form_col'>* Pr&eacute;nom :</label><input type="text" name="prenom" maxlength = "40" value="<?php echo $perso->pseudo(); ?>" />
					<span class="verif_form"><?php if(isset ($_GET['check'])){ echo $perso->setPrenom($_POST['prenom']); }  ?></span><br>
					<label for="street" class='form_col'>adresse :</label><input type="text" name="adresse" value="<?php echo $perso->adresse(); ?>" />
					<span class="verif_form"><?php if(isset ($_GET['check'])){ echo $perso->setAdresse($_POST["adresse"]); }  ?></span><br>
					<label for="city" class='form_col'>* ville :</label><input type="text" name="ville"  value="<?php echo $perso->ville(); ?>" />
					<span class="verif_form"><?php if(isset ($_GET['check'])){ echo $perso->setVille($_POST['ville']); }  ?></span><br>
					<label for="pays" class='form_col'>* Pays :</label><select name="pays"><?php
					$dom = new DomDocument();
					$dom->load('src/xml/country.xml');
					$liste = $dom->getElementsByTagName('pays');
					echo "<option value='$perso->pays()'>".$perso->pays()."</option>";
					foreach($liste as $pays){ 
						$State = $pays->firstChild->nodeValue;
						echo "<option value='$State'>".$State."</option>"; 
					}
					
					?></select>
					<span class="verif_form"><?php if(isset ($_POST['pays'])&& isset ($_GET['check'])){ echo $perso->setPays($_POST['pays']); }  ?></span><br>

					</fieldset>
					<fieldset><legend>Contacts</legend>
					<label for="email" class='form_col'>* Votre adresse Mail :</label><input type="email" name="email" value="<?php echo $perso->email(); ?>" />
					<span class="verif_form"><?php if(isset ($_POST['email']) && isset ($_GET['check'])){ echo $perso->setEmail($_POST['email']); }  ?></span><br>
					<label for="website" class='form_col'>Votre site web :</label><input type="input" name="website" value="<?php echo $perso->web(); ?>"/>
					<span class="verif_form"><?php if(isset ($_POST['website']) && isset ($_GET['check'])){ echo $perso->setWeb($_POST['website']); }  ?></span><br>
					</fieldset>
	
					<fieldset><legend>Profil sur le forum</legend>
					<label for="avatar" class='form_col'>Choisissez votre avatar :</label><input type="file" name="avatar" id="avatar" value="<?php echo $perso->avatar(); ?>" /><br />
					<span class="verif_form"><?php if( isset ($_GET['check'])){ echo $perso->addAvatar($_FILES); }  ?></span><br>
					<label for="signature" class='form_col'>Signature :</label><textarea cols="40" rows="4" name="signature" id="signature" ><?php echo $perso->signature(); ?></textarea>
					<span class="verif_form"><?php if(isset ($_GET['check'])){ echo $perso->setSignature($_POST['signature']); }  ?></span><br>
					</fieldset>
					Les champs pr&eacute;c&eacute;d&eacute;s d un * sont obligatoires
					<p>	<?php 
					echo $perso->error();
		
					if(isset ($_GET['check'])){
						if($perso->error() == 0){
							$manager = new ManagerMember($db);
							$manager->updateMember($perso);
						}
					}
					?>
					 </p>
					<input type="submit" value ="Mettre à jour">
					</form>
				<?php }
			break;
		}
		echo "</div>";
		
	}
	else{
		echo "<p>Vous devez être identifié pour voir les profils</p>";
		header("index.php");
	}
	?>

</body>

</html>
