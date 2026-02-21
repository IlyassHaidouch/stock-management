<?php
	require_once('identifier.php');
	require_once('connexion.php');
	$numero = isset($_POST['numero'])?$_POST['numero']:0;
	$date = isset($_POST['date'])?$_POST['date']:"";
	$reference = isset($_POST['reference'])?$_POST['reference']:0;
	$designation = isset($_POST['designation'])?$_POST['designation']:"";
	$categorie = isset($_POST['categorie'])?strtoupper($_POST['categorie']):"";
	$prixV = isset($_POST['prixV'])?$_POST['prixV']:0;
	$quantite = isset($_POST['quantite'])?$_POST['quantite']:"";
	$total = isset($_POST['total'])?$_POST['total']:"";
	
	echo "numero : $numero & prix de vente  : $prixV & quantite : $quantite & total : $total";
	$requete = "update sorties set _date=?, reference=?, designation=?, categorie=?, prix_vente=?, quantite=?, total=? where numero=?";
	$params = array($date, $reference, $designation, $categorie, $prixV, $quantite, $total, $numero);

	$resultat = $pdo->prepare($requete);

	$resultat->execute($params);

	 
    
	header('location:sorties.php');

	
?>