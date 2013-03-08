<?php
$user="root";
$password="";
$dsn = 'mysql:host=localhost;dbname=noteconcept';
try{
	$db = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch (Exception $e) {
	echo "Connection � MySQL impossible : ", $e->getMessage();
}
?>