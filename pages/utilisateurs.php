<?php
    require_once('identifier.php');
	require_once("connexion.php");
	$login = isset($_GET['login'])?$_GET['login']:"";

	 
	$size = isset($_GET['size'])?$_GET['size']:6;
	$page = isset($_GET['page'])?$_GET['page']:1;
	$offset = ($page-1)*$size;


	$requete = "select * from utilisateur where login like '%$login%' limit $size offset $offset";
	$requeteCount = "select count(*) countU from utilisateur where login like '%$login%'";

	
	
	$resultatUser = $pdo->query($requete);
	$resultatCount = $pdo->query($requeteCount);
	$tabCount = $resultatCount->fetch();
	$nbrUser = $tabCount['countU'];

	$reste = $nbrUser%$size;
	if($reste===0){
		$nbrPage = $nbrUser/$size;
	}
	else{
		$nbrPage = floor($nbrUser/$size)+1; //la partie entière d'un nombre décimal
	}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../css/monstyle.css">
	<title>gestion de utilisateurs</title>
</head>
<body>  
   
	<?php include('menu.php'); ?>
	<div class="container">
		<div class="panel panel-success margetop">
			<div class="panel-heading">Rechercher les utilisateurs</div>

			<div class="panel-body">
				<form method="get" action="utilisateurs.php" class="form-inline">
					<div class="form-group">
						<input type="text" name="login" placeholder="login" class="form-control" value="<?php echo $login;?>">
					</div>
					
					<button type="submit" value="Rechercher..." class="btn btn-success"><span class="glyphicon glyphicon-search"></span> Chercher...</button>
					&nbsp &nbsp
					

				</form>
			</div>

	    </div>
	</div>

	<div class="container">
		<div class="panel panel-primary">
			<div class="panel-heading">Listes des utilisateurs (<?php echo $nbrUser?> Utilisateurs)</div>


			<div class="panel-body">
				<table class="table table-striped table-bordered">
					<thead>
						<tr>
							<th>idUser</th> <th>Login</th> <th>Email</th> <th>Role</th> <th>Actions</th>
						</tr>
					</thead>

					<tbody>
							<?php while($user=$resultatUser->fetch()){ ?>

								<tr class="<?php echo $user['etat']==1?'success':'danger';?>">
									<td><?php echo $user['iduser'];?> </td>
									<td><?php echo $user['login'];?> </td>
									<td><?php echo $user['email'];?> </td>
									<td><?php echo $user['role'];?> </td>
									
									<td>
                                        
										<a  href="editerUser.php?idU=<?php echo $user['iduser'];?>">
                                            <span class="glyphicon glyphicon-edit"></span>
										</a>
										&nbsp&nbsp

										<a onclick="return confirm('Etes vous sur vouloir supprimer cet utilisateur')"href="supprimerUser.php?idU=<?php echo $user['iduser'];?>">
											<span class="glyphicon glyphicon-trash"></span>
										</a>
                                        &nbsp&nbsp

                                        <a href="activerUser.php?idU=<?php echo $user['iduser'];?>&etat=<?php echo $user['etat'];?>">
                                            <?php
                                                if($user['etat']==1){
                                                    echo '<span class="glyphicon glyphicon-remove"></span>';
                                                }
                                                else {
                                                    echo '<span class="glyphicon glyphicon-ok"></span>';
                                                }
                                            ?>
                                        </a>
									</td>
								</tr>

							<?php } ?>
					</tbody>

				</table>
					<div>
						<ul class="pagination pagination-md">
							<?php for($i=1; $i <= $nbrPage; $i++){ ?>
								   <li class="<?php if($page==$i){ echo 'active'; } ?>">
									   	<a href="utilisateurs.php?page=<?php echo $i;?>&login=<?php echo $login;?>">
									   	<?php echo $i;?>
									    </a>
								   </li>  
							<?php } ?>	   
						</ul>					

					</div>
			</div>
		</div>
	</div>

</body>
</html>