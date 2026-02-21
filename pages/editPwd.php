<?php
    require_once('identifier.php');

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../css/monstyle.css">
	<title>Edition d'un utilisateur</title>
</head>
<body>

	

	<div class="container">
		<div class="panel panel-primary margetop">
			<div class="panel-heading">Changement de passe :</div>
			<div class="panel-body">
				<form method="post" action="updatePwd.php" class="form">

					<div class="form-group">
						<label>Compte : <?php echo $_SESSION['user']['login']; ?></label>
					</div>

					<div class="form-group">
						<label for="login">Ancien Mot de passe:</label>
						<input type="password" name="oldpwd" value="" placeholder="Taper votre Ancien Mot de passe" class="form-control" required>
					</div>

                    <div class="form-group">
						<label for="email">Nouveau Mot de passe:</label>
						<input type="password" name="newpwd" value="" placeholder="Taper votre Nouveau Mot de passe"class="form-control" required>
					</div>
					
					<button type="submit" value="Rechercher..." class="btn btn-success"><span class="glyphicon glyphicon-save"></span> Enregistrer</button>
                    
                   
                    
					
				</form>
			</div>
		</div>
	</div>

</body>
</html>