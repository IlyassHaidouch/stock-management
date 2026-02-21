<?php
    require_once('connexion.php');
    require_once('../les_fonctions/fonctions.php');


    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $login = $_POST['login'];
        $pwd1 = $_POST['pwd'];
        $pwd2 = $_POST['pwd2'];
        $email = $_POST['email'];

        $validationErrors = array();
        if (isset($login)) {
            $filtredLogin = filter_var($login, FILTER_SANITIZE_STRING);
    
            if (strlen($filtredLogin) < 4) {
                $validationErrors[] = "Erreur!!! Le login doit contenir au moins 4 caratères";
            }
        }
    
        if (isset($pwd1) && isset($pwd2)) {
    
            if (empty($pwd1)) {
                $validationErrors[] = "Erreur!!! Le mot ne doit pas etre vide";
            }
    
            if (md5($pwd1) !== md5($pwd2)) {
                $validationErrors[] = "Erreur!!! les deux mot de passe ne sont pas identiques";
    
            }
        }
    
        if (isset($email)) {
            $filtredEmail = filter_var($login, FILTER_SANITIZE_EMAIL);
    
            if ($filtredEmail != true) {
                $validationErrors[] = "Erreur!!! Email  non valid";
    
            }
        } 
        if(empty($validationErrors)){
            if(rechercher_par_login($login)==0 && rechercher_par_email($email)==0){
                $requete = $pdo->prepare('insert into utilisateur(login, email, role, etat, pwd) values(?, ?, ?, ?, ?)');
                $requete->execute(array($login, $email, 'VISITEUR', 0, md5($pwd1)));
                $success_msg = "Félicitation, votre compte est crée, mais inactif jusqu'à l'activation par l'admin"; 
            }
            else{
                if(rechercher_par_login($login) > 0){
                    $validationErrors[] = "Désolé, le login existe deja";
                }
                if(rechercher_par_email($email) > 0){
                    $validationErrors[] = "Désolé, cet email existe deja";
                }
            }     
        }
        
        
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>nouvel utilisateur</title>
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../css/monStyle.css">
</head>
<body>

    <div class="containerc col-md-6 col-md-offset-3">
        <form class="form" method="post">
            <h1 class="text-center">Création d'un nouveau compte utilisateur</h1>

            <div class="input-container">
                <input type="text"
                required="required"
                minlength="4"
                title="le login doit contenir au moins 4 caractères..."
                placeholder="Taper votre nom d'utilisateur"
                name="login"
                autocomplete="off"
                class="form-control">
            </div>


            <div class="input-container">
                <input type="password"
                required="required"
                minlength="3"
                title="le Mot de passse doit contenir au moins 3 caractères..."
                placeholder="Taper votre mot de passe"
                name="pwd"
                autocomplete="off"
                class="form-control">
            </div>  

            <div class="input-container">
                <input type="password"
                required="required"
                minlength="3"
                title="le Mot de passse doit contenir au moins 3 caractères..."
                placeholder="retaper votre mot de passe pour le confirmer"
                name="pwd2"
                autocomplete="off"
                class="form-control">
            </div>

            <div class="input-container">
                <input type="email"
                required="required"
                placeholder="Taper votre email"
                name="email"
                autocomplete="off"
                class="form-control">
            </div>

            <input type="submit" value="Enregistrer" class="btn btn-primary">
        </form>
        <br>
        <?php if(isset($validationErrors) && !empty($validationErrors)){       
            foreach($validationErrors as $error){
                echo '<div class="alert alert-danger">'.$error.'</div>';
            }   
        }
        ?>
    </div>
</body>
</html>