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
			echo "<h2 class='HeadProfil'>Profil de ".$perso->pseudo()."</h2>";
		}else{
			echo "<h2 class='HeadProfil'>Profil de ".$perso2->pseudo()."</h2>";
		}
		switch ($action){
			case "consulter":
				echo "<img src='src/image-avatar/".$perso2->avatar()."' width='75px' height='75px'>";
			break;
			case "modif":
				if($_SESSION['id'] == $perso->id()){
					echo "modifier le profil";
				}
			break;
		}
		
	}
	else{
		echo "<p>Vous devez être identifié pour voir les profils</p>";
		header("index.php");
	}
	?>

</body>

</html>
