<?php
    require_once('identifier.php');
    require_once('connexion.php');

    $iduser = $_SESSION['user']['iduser'];

    $oldpwd = isset($_POST['oldpwd'])?$_POST['oldpwd']:"";
    $newpwd = isset($_POST['newpwd'])?$_POST['newpwd']:"";

    $requete = "select * from utilisateur where iduser=$iduser and pwd=MD5('$oldpwd')";

    $resultat = $pdo->prepare($requete);
    $resultat->execute();

    $msg = "";
    $url = "login.php";
    $interval = 3;
    if($resultat->fetch()){

        $requete = "update utilisateur set pwd=MD5(?) where iduser=?";
        $params = array($newpwd, $iduser);
        $resultat = $pdo->prepare($requete);
        $resultat->execute($params);
        $msg = "<div class='alert alert-success'>
                    <strong>Félicitation!</strong> Votre mot de passe est modifié avec succès !!!
                </div>";      
    }
    else{
        $msg = "<div class='alert alert-danger'>
                    <strong>Erreur!</strong> L'ancien mot de passe est incorrect !!!
                </div>";
        $url = $_SERVER['HTTP_REFERER'];      
    }
    
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <?php
            header("refresh:$interval;url=$url");
            echo $msg;
        ?>
    </div>
</body>
</html>