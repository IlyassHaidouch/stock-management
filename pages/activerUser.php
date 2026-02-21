<?php
    session_start();
	if(isset($_SESSION['user'])){
		require_once('connexion.php');
		$idU = isset($_GET['idU'])?$_GET['idU']:0;
		$etat = isset($_GET['etat'])?$_GET['etat']:"";
		

		$requete = "update utilisateur set etat=? where iduser=?";
		
		if($etat==1){
			$newEtat = 0;
		}
		else{
			$newEtat = 1;
		}

		$params = array($newEtat, $idU);
		$resultat = $pdo->prepare($requete);
		
		$resultat->execute($params);
		header('location:utilisateurs.php');
	}
	else{
		header('location:login.php');
	}

	
?>