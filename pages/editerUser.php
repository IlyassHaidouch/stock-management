<?php
    require_once('identifier.php');
    require_once('connexion.php');
    $idU = isset($_GET['idU'])?$_GET['idU']:0;
    $requete = "select * from utilisateur where iduser = '$idU'";
    $resultat = $pdo->query($requete);
    $user = $resultat->fetch();

    $login = $user['login'];
    $email = $user['email'];
    $role = strtoupper($user['role']);
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

	<?php include('menu.php'); ?>

	<div class="container">
		<div class="panel panel-primary margetop">
			<div class="panel-heading">Edition de la marchandise</div>
			<div class="panel-body">
				<form method="post" action="updateUser.php" class="form">

					<div class="form-group">
						<label for="idU">id de l'utilisateur : <?php echo $idU; ?></label>
						<input type="hidden" name="idU" value="<?php echo $idU; ?>" class="form-control">
					</div>

					<div class="form-group">
						<label for="login">Login:</label>
						<input type="text" name="login" value="<?php echo $login;?>" class="form-control">
					</div>

                    <div class="form-group">
						<label for="email">Email:</label>
						<input type="text" name="email" value="<?php echo $email;?>" class="form-control">
					</div>
					
                    <div class="form-group">
                        <label for="role">Role:</label>
						<select name="role" class="form-control">
                            <option value="ADMIN" <?php if($role=="ADMIN"){ echo "selected";}?>>Administrateur</option>
                            <option value="VISITEUR" <?php if($role=="VISITEUR"){ echo "selected";}?>>Visiteur</option>
                        </select>
					</div>
					<button type="submit" value="Rechercher..." class="btn btn-success"><span class="glyphicon glyphicon-save"></span> Enregistrer</button>
					
					&nbsp; &nbsp;
                    <a href="editPwd.php?idU=<?php echo $user['iduser'];?>">Changer le mot de passe</a>

				</form>
			</div>
		</div>
	</div>

</body>
</html>
				<script src="../js/editerM.js"></script>