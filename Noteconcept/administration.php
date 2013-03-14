<?php
session_start();
include('include/constante.inc.php');
include_once('include/autochargement.inc.php');
include('include/use.inc.php');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
<title>accueil</title>
<link rel="stylesheet" type="text/css" href="src/css/design.css">
<link rel="stylesheet" type="text/css" href="src/css/menuAdmin.css">
</head>
<body>
	<?php
	include('include/header.inc.php');
	if($perso->droit() == ADMINISTRATEUR){
		include("include/menuAdmin.inc.php");
		echo "<div id='corpAdmin'>
		Je suis la div du corp de l'administration
		
		</div>";

	}
	else{
		echo "Vous n'êtes pas autorisé à aller sur cette page.";
	}

	?>

</body>

</html>
