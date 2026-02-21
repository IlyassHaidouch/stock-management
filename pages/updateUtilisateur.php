<?php
    require_once('identifier.php');
	require_once('connexion.php');
	$idU = isset($_POST['idU'])?$_POST['idU']:0;
	$login = isset($_POST['login'])?$_POST['login']:"";
	$email = isset($_POST['email'])?$_POST['email']:"";
	

	$requete = "update utilisateur set login=?, email=? where iduser=?";
	$params = array($login, $email, $idU);

	$resultat = $pdo->prepare($requete);

	$resultat->execute($params);

	 
    
	header('location:login.php');

	
?>