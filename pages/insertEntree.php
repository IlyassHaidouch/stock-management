<?php
	require_once('identifier.php');
	require_once('connexion.php');

	$date = isset($_POST['date'])?$_POST['date']:"";
	$reference = isset($_POST['reference'])?$_POST['reference']:"";
	$designation = isset($_POST['designation'])?$_POST['designation']:"";
	$categorie = isset($_POST['categorie'])?strtoupper($_POST['categorie']):"";
	$coutA = isset($_POST['coutA'])?$_POST['coutA']:"";
	$quantite = isset($_POST['quantite'])?$_POST['quantite']:"";
	$total = isset($_POST['total'])?$_POST['total']:"";
	
	echo "total : $total & reference : $reference & coutA : $coutA & quantite : $quantite";
	$requete = "insert into entrees(_date, reference, designation, categorie, cout_achat, quantite, total) values(?, ?, ?, ?, ?, ?, ?)";
	$params = array($date, $reference, $designation, $categorie, $coutA, $quantite, $total);

	$resultat = $pdo->prepare($requete);

	$resultat->execute($params);

	
    
	header("location:entrees.php");

	
?>