<?php
    session_start();
    if(isset($_SESSION['user'])){
    require_once('connexion.php');
    $idU = isset($_GET['idU'])?$_GET['idU']:0; // c'est un lien hypertexte , donc les donnnées vont transemetre par l'url.
    $requete = "delete from utilisateur where iduser=?";
    $params = array($idU);
    $resultat = $pdo->prepare($requete);
    $resultat->execute($params);

    header('location:utilisateurs.php');
    }
    else{
        header('location:login.php');
    }
?>