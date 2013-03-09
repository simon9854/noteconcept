<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
	<head>
	<title>Inscription Membre</title>
		<link rel="stylesheet" type="text/css" href="src/css/design.css" >
		
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	</head>
<body>
	<?php
	include('include/autochargement.inc.php');
	include('include/use.inc.php');
	include('include/header.inc.php');
	//le fichier use permet la connection à la BDD

	
	?>
	<h1 id="titr" align="center">Inscription</h1>
	<?php 
	//trouver une solution pour crée une fonction dans membre qui implémentate cette fonciton
	if(isset ($_GET['check']) and !empty ($_POST)){
		$membre = new Member();
		$msg = $membre->testMember($_POST);
		if($msg != ""){
			echo"<span class='message_error'><img src='src/image/ico-close.gif' alt='erreur' id='img-erreur'> ";
			echo"$msg". "ou le mot de passe diff&eacute;rent de la confirmation. </span>";
		}
	}

	//réussir a créer un meilleur design changement des champs mixer avec le zebra_form regitration
	?>
	<form method="POST" action="form.member.php?check=1" enctype="multipart/form-data" id="myForm">

	<fieldset><legend>Identifiants</legend>
	<label for="sexe" class='form_col'>* Sexe :</label><select name="sexe">
	<option value="M">Homme</option>
	<option value="F">Femme</option>
	</select>
	<span class="verif_form"><?php if(isset($_POST['sexe']) && isset ($_GET['check'])) echo $membre->setSexe($_POST['sexe']);  ?> </span><br>
	<label for="loginName" class='form_col'>* Pseudo :</label><input name="pseudo" type="text" maxlength = "40" value="<?php echo @$pseudo  ?>" />
	<span class="verif_form"><?php if(isset ($_POST['pseudo'])&& isset ($_GET['check'])){ echo $membre->setPseudo($_POST['pseudo']); }  ?></span><br>
	<label for="age" class='form_col'>*&acirc;ge</label><input name="age" type="number" maxlength = "3" value="<?php echo @$age?>" />
	<span class="verif_form"><?php if(isset ($_POST['age'])&& isset ($_GET['check'])){ echo  $membre->setAge($_POST['age']); }  ?></span><br>
	<label for="pass" class='form_col'>* Mot de Passe :</label><input type="password" name="mdp" maxlength = "40" value="<?php echo @$mdp ?>" />
	<span class="verif_form"><?php if(isset ($_POST['mdp'])&& isset ($_GET['check'])){ echo $membre->testMdp($_POST['mdp'], $_POST['mdp_confirm']); }  ?></span><br>
	<label for="confirm" class='form_col'>* Confirmer le mot de passe :</label><input type="password" name="mdp_confirm" maxlength = "40" value="<?php echo @$confirm ?>" />
	<span class="verif_form"></span><br>
	<label for="lastname" class='form_col'>* Nom :</label><input type="text" name="nom" maxlength = "40"  value="<?php echo @$nom ?>" /></input>
	<span class="verif_form"><?php if(isset ($_POST['nom'])&& isset ($_GET['check'])){ echo $membre->setNom($_POST['nom']); }  ?></span><br>
	<label for="firstName" class='form_col'>* Pr&eacute;nom :</label><input type="text" name="prenom" maxlength = "40" value="<?php echo @$prenom ?>" />
	<span class="verif_form"><?php if(isset ($_POST['prenom'])&& isset ($_GET['check'])){ echo $membre->setPrenom($_POST['prenom']); }  ?></span><br>
	<label for="street" class='form_col'>adresse :</label><input type="text" name="adresse" value="<?php echo @$adresse ?>" />
	<span class="verif_form"><?php if(isset ($_POST['adresse'])&& isset ($_GET['check'])){ echo $membre->setAdresse($_POST["adresse"]); }  ?></span><br>
	<label for="city" class='form_col'>* ville :</label><input type="text" name="ville"  value="<?php echo @$ville ?>" />
	<span class="verif_form"><?php if(isset ($_POST['ville'])&& isset ($_GET['check'])){ echo $membre->setVille($_POST['ville']); }  ?></span><br>
	<label for="pays" class='form_col'>* Pays :</label><select name="pays"><?php
			$dom = new DomDocument();
		$dom->load('src/xml/country.xml');
		$liste = $dom->getElementsByTagName('pays');
		foreach($liste as $pays){ 
		$State = $pays->firstChild->nodeValue;
				echo "<option value='$State'>".$State."</option>"; 
		}

	?> </select>
		<span class="verif_form"><?php if(isset ($_POST['pays'])&& isset ($_GET['check'])){ echo $membre->setPays($_POST['pays']); }  ?></span><br>

	</fieldset>
		<fieldset><legend>Contacts</legend>
		<label for="email" class='form_col'>* Votre adresse Mail :</label><input type="email" name="email"  />
		<span class="verif_form"><?php if(isset ($_POST['email'])&& isset ($_GET['check'])){ echo $membre->setEmail($_POST['email']); }  ?></span><br>
		<label for="website" class='form_col'>Votre site web :</label><input type="url" name="website" />
		<span class="verif_form"><?php if(isset ($_POST['website'])&& isset ($_GET['check'])){ echo $membre->setWeb($_POST['website']); }  ?></span><br>
		</fieldset>
	
		<fieldset><legend>Profil sur le forum</legend>
		<label for="avatar" class='form_col'>Choisissez votre avatar :</label><input type="file" name="avatar" id="avatar"  /><br />
		<span class="verif_form"><?php if( isset ($_GET['check'])){ echo $membre->addAvatar($_FILES); }  ?></span><br>
		<label for="signature" class='form_col'>Signature :</label><textarea cols="40" rows="4" name="signature" id="signature" >La signature est limit&eacute;e &agrave 200 caract&egrave;res</textarea>
		<span class="verif_form"><?php if(isset ($_POST['signature'])&& isset ($_GET['check'])){ echo $membre->setSignature($_POST['signature']); }  ?></span><br>
		</fieldset>
		Les champs pr&eacute;c&eacute;d&eacute;s d un * sont obligatoires
		<p>	<?php 
	
		
		if(isset ($_GET['check'])){
			if($membre->error() == 0){
				$manager = new ManagerMember($db);
				$manager->addMember($membre);
			}
		}
		?>
		 </p>
		<input type="submit" value ="Enregistrez-vous"> <input type="reset" value="R&eacute;initialiser le formulaire" />
		</form>
	
</body>

</html>