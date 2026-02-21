<?php
    session_start();
    if(isset($_SESSION['erreurLogin'])){
        $erreurLogin = $_SESSION['erreurLogin'];
    }
    else{
        $erreurLogin = "";
    }

    session_destroy();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../css/monstyle.css">
	<title>Se connecter</title>
</head>
<body>


	<div class="container col-lg-4 col-lg-offset-4 col-md-6 col-md-offset-3">
		<div class="panel panel-primary margetop">
			<div class="panel-heading">Se connecter</div>
			<div class="panel-body">
				<form method="post" action="seConnecter.php" class="form">
                    <?php if(!empty($erreurLogin)){?>
                        <div class="alert alert-danger">
                            <?php echo $erreurLogin;?>
                        </div>
                    <?php }?>
                    <div class="form-group">
						<label for="login">Login:</label>
						<input type="text" name="login" placeholder="Login" class="form-control" id="login">
					</div>

					<div class="form-group">
						<label for="pwd">Mot de passe:</label>
						<input type="password" name="pwd" placeholder="mot de passe"  id="pwd" class="form-control" onkeyup="fetchData()">

					</div>
					
					<button type="submit" class="btn btn-success btn-block"><span class="glyphicon glyphicon-log-in"></span> Se connecter</button>
					<br>
					
						<a href="#">Mot de passe Oublié</a>
						&nbsp;&nbsp;&nbsp;&nbsp;
						<a href="nouvelUtilisateur.php">Créer un compte</a>						
					
					
				</form>
			</div>
		</div>
	</div>

</body>
</html>

		
		 
			
	
		