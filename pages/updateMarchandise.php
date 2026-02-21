<?php
	require_once('identifier.php');
	require_once('connexion.php');
	$reference = isset($_POST['reference'])?$_POST['reference']:0;
	$designation = isset($_POST['designation'])?$_POST['designation']:"";
	$categorie = isset($_POST['categorie'])?strtoupper($_POST['categorie']):"";
	$stockI = isset($_POST['stockI'])?$_POST['stockI']:"";
	$prixU = isset($_POST['prixU'])?$_POST['prixU']:"";
	$total = isset($_POST['total'])?$_POST['total']:"";
	

	$requete = "update marchandise set designation=?, categorie=?, stock_initial=?, prix_unitaire=?, total=? where reference=?";
	$params = array($designation, $categorie, $stockI, $prixU, $total, $reference);

	$resultat = $pdo->prepare($requete);

	$resultat->execute($params);

	 
    
	header('location:marchandise.php');

	
?>