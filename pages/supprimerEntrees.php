<?php
    session_start();
    if(isset($_SESSION['user'])){
        require_once('connexion.php');
        $numero = isset($_GET['numero'])?$_GET['numero']:0; // c'est un lien hypertexte , donc les donnnées vont transemetre par l'url.
        $requete = "delete from entrees where numero=?";
        $params = array($numero);
        $resultat = $pdo->prepare($requete);
        $resultat->execute($params);

        header('location:entrees.php');
    }
    else{
        header('location:login.php');
    }
?>