<?php
session_start();
include_once('include/autochargement.inc.php');
include('include/use.inc.php');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
<title>Profil</title>
<link rel="stylesheet" type="text/css" href="src/css/design.css">
</head>
<body>
	<?php
	include('include/header.inc.php');
	if(isset($_GET['id']) && $_GET['id'] != -1){
		$id = $_GET['id'];

		
	}
	else{
		echo "<p>Vous devez être identifié pour voir les profils</p>";
		header("index.php");
	}
	?>

</body>

</html>
