<?php
    session_start();
	if(isset($_SESSION['user'])){
        require_once('connexion.php');
        $reference = isset($_GET['reference'])?$_GET['reference']:0; // c'est un lien hypertexte , donc les donnnées vont transemetre par l'url.
        $requete = "delete from marchandise where reference=?";
        $params = array($reference);
        $resultat = $pdo->prepare($requete);
        $resultat->execute($params);
        header('location:marchandise.php');
    }
    else{
        header('location:login.php');
    }
?>