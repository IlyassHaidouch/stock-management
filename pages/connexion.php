<?php
try {

    $pdo = new PDO("mysql:host=db;dbname=stock_management",
        "root", "root123");

}catch (Exception $e){
    die('Erreur : ' . $e->getMessage());

    //die('Erreur : impossible de se connecter à la base de donnée');
}
?>

