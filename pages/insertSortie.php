<?php
	require_once('identifier.php');
	require_once('connexion.php');

	$date = isset($_POST['date'])?$_POST['date']:"";
	$reference = isset($_POST['reference'])?$_POST['reference']:"";
	$designation = isset($_POST['designation'])?$_POST['designation']:"";
	$categorie = isset($_POST['categorie'])?strtoupper($_POST['categorie']):"";
	$prixV = isset($_POST['prixV'])?$_POST['prixV']:"";
	$quantite = isset($_POST['quantite'])?$_POST['quantite']:"";
	$total = isset($_POST['total'])?$_POST['total']:"";
	
	echo "total : $total & reference : $reference & prixV : $prixV & quantite : $quantite & date : $date";
	$requete = "insert into sorties(_date, reference, designation, categorie, prix_vente, quantite, total) values(?, ?, ?, ?, ?, ?, ?)";
	$params = array($date, $reference, $designation, $categorie, $prixV, $quantite, $total);

	$resultat = $pdo->prepare($requete);

	$resultat->execute($params);

	
    
	header("location:sorties.php");

	
?>