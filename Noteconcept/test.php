<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
	<head>
	<title>Inscription Membre</title>
		<link rel="stylesheet" type="text/css" href="src/css/design.css" >
		<link rel="stylesheet" type="text/css" href="src/css/zebra_form.css" >
        <script src="src/javascript/jquery.js"></script>
        <script src="src/javascript/zebra_form.js"></script>
        <script src="src/javascript/zebra_form.src.js"></script>


		
		
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	</head>
<body>

	<?php 
	include('include/header.inc.php');
	include('include/autochargement.inc.php');
	require '/module/form_jquery/Zebra_Form.php';
	?>
	<h1 id="titr" align="center">Inscription</h1>
	<?php
	echo "<div id='form_zebra'>";
	//trouver une solution pour crée une fonction dans membre qui implémentate cette fonciton
	$form = new Zebra_Form('inscription');
	
	$form->add('label', 'label_sexe', 'sexe', 'Sexe:');
	$obj = & $form->add('radios', 'sexe', array(
			'H' =>  'Homme',
			'F' =>  'Femme',
	));
	$obj->set_rule(array(
			'required' => array('error', 'Sexe non selectionné')
	));
	

	$form->add('label', 'label_age', 'age', 'âge');
	$obj = & $form->add('text', 'age');
	$obj->set_rule(array(
			'required'  =>  array('error', 'Veuillez entrer votre âge.'),
	));

	
	
	$form->add('label', 'label_pseudo', 'pseudo', 'Pseudo');
	$obj = & $form->add('text', 'pseudo');
	$obj->set_rule(array(
			'required'  =>  array('error', 'Veuillez entrer votre Pseudo'),
	));
	
	$form->add('label', 'label_name', 'name', 'Nom');
	$obj = & $form->add('text', 'name');
	$obj->set_rule(array(
			'required'  =>  array('error', 'Veuillez entrer votre nom'),
	));
	
	$form->add('label','label_prenom', 'prenom', 'Pr&eacute;nom');
	$obj = & $form->add('text','prenom');
	$obj->set_rule(array(
			'required' => array('error', 'Veuillez entrer votre Prénom'),		
	));
	

	
	$form->add('label', 'label_email', 'email', 'Email');
	$obj = &$form->add('text', 'email', "", array('data-prefix' => 'img:src/image/letter.png'));
	
	// set rules
	$obj->set_rule(array(
			'required'  =>  array('error', 'Veuillez entrer votre email'),
			'email'     =>  array('error', 'Email non valide!'),
	
	));
	$form->add('note', 'note_email', 'email', 'votre adresse doit etre au format toto@');
	// "password"
	$form->add('label', 'label_password', 'password', 'Password');
	$obj = & $form->add('password', 'password', '', array('autocomplete' => 'off'));
	
	$obj->set_rule(array(
	
			'required'  => array('error', 'Password manquant!'),
			'length'    => array(6, 10, 'error', 'le mdp doit etre entre 6 et 10 characters'),
	
	));
	$form->add('label', 'label_confirm_password', 'confirm_password', 'Confirm password:');
	$obj = & $form->add('password', 'confirm_password');
	$obj->set_rule(array(
			'compare' => array('password', 'error', 'Password incorrect')
	));
	
	$form->add('label','label_ville','ville','Ville');
	$obj = &$form->add('text', 'ville', "", array('data-prefix' => 'img:./src/image/letter.png'));
	$obj->set_rule(array(
	
			'required'  => array('error', 'veulllez entrer la ville'),
	));
	
	$dom = new DomDocument();
	$dom->load('src/xml/country.xml');
	$liste = $dom->getElementsByTagName('pays');
	$form->add('label', 'label_pays', 'pays', 'Pays:');
	$obj = & $form->add('select', 'pays', '', array('other' => true));
	$obj->add_options(array(
		'France',
		'Allemagne',
		'',
	));
	$obj->set_rule(array(
		'required' => array('error', 'Veuillez entrer le Pays')
	));
	$form->add('label','label_adresse','adresse','Adresse :');
	$obj = &$form->add('text', 'adresse', '', array('data-prefix' => 'img:src/image/letter.png'));
	
	$form->add('label', 'label_website', 'website', 'Site web:');
	$obj = & $form->add('text', 'website', '', array('data-prefix' => 'http://'));
	$obj->set_rule(array(
			'url'   =>  array(true, 'error', 'Invalid URL specified!'),
	));
	$form->add('label', 'label_message', 'signature', 'Signature:');
	$obj = & $form->add('textarea', 'signature');
	$obj->set_rule(array(
			'length'    => array(0, 120, 'error', 'Taille maximun 120', true),
	));
	
	
	$form->add('captcha', 'captcha_image', 'captcha_code');
	$form->add('label', 'label_captcha_code', 'captcha_code', 'Anti-Robot');
	$obj = & $form->add('text', 'captcha_code');
	$form->add('note', 'note_captcha', 'captcha_code', 'You must enter the characters with black color that stand
	    out from the other characters', array('style'=>'width: 200px'));
	$obj->set_rule(array(
			'required'  => array('error', 'Enter the characters from the image above!'),
			'captcha' => array('error', 'Characters from image entered incorrectly!')
	));
	$form->assets_path('./module/form_jquery/','./module/form_jquery/');
	


	$form->add('submit', 'btnsubmit', 'Envoyer');
	// validate the form
	if ($form->validate()) {
	
		// do stuff here
	
	}
	
	// auto generate output, labels above form elements
	$form->render();
	echo "</div>";
	?>
	
	
</body>
</html>