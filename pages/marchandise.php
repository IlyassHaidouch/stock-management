<?php
	require_once('identifier.php');


	require_once("connexion.php");
	$nomM = isset($_GET['nomM'])?$_GET['nomM']:"";
	$categorie = isset($_GET['categorie'])?$_GET['categorie']:"all";

	 
	$size = isset($_GET['size'])?$_GET['size']:6;
	$page = isset($_GET['page'])?$_GET['page']:1;
	$offset = ($page-1)*$size;

	if($categorie=="all"){
		$requete = "select * from marchandise where designation like '%$nomM%' limit $size offset $offset";
		$requeteCount = "select count(*) countM from marchandise where designation like '%$nomM%'";
	}
	else{
		$requete = "select * from marchandise where designation like '%$nomM%' and categorie='$categorie' limit $size offset $offset";
		$requeteCount = "select count(*) countM from marchandise where designation like '%$nomM%' and categorie='$categorie'";
	}
	
	$resultatM = $pdo->query($requete);
	$resultatCount = $pdo->query($requeteCount);
	$tabCount = $resultatCount->fetch();
	$nbrMarchandise = $tabCount['countM'];

	$reste = $nbrMarchandise%$size;
	if($reste===0){
		$nbrPage = $nbrMarchandise/$size;
	}
	else{
		$nbrPage = floor($nbrMarchandise/$size)+1; //la partie entière d'un nombre décimal
	}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../css/monstyle.css">
	<title>gestion de stocks</title>
</head>
<body>  
   
	<?php include('menu.php'); ?>
	<div class="container">
		<div class="panel panel-success margetop">
			<div class="panel-heading">Rechercher les marchandises</div>

			<div class="panel-body">
				<form method="get" action="marchandise.php" class="form-inline">
					<div class="form-group">
						<input type="text" name="nomM" placeholder="Désignation" class="form-control" value="<?php echo $nomM;?>">
					</div>

					<label for="categorie">Catégorie:</label>

					<select name="categorie" class="form-control" id="categorie" onchange="this.form.submit()">
						<option value="all" <?php if($categorie=="all") echo "selected"?>>Tous les catégories</option>
						<option value="Pare-brise" <?php if($categorie=="Pare-brise") echo "selected"?>>pare-brise</option>
						<option value="porte-av-g" <?php if($categorie=="porte-av-g") echo "selected"?>>porte-av-g</option>
						<option value="porte-av-d" <?php if($categorie=="porte-av-d") echo "selected"?>>porte-av-d</option>
						<option value="porte-ar-g" <?php if($categorie=="porte-ar-g") echo "selected"?>>porte-ar-g</option>
						<option value="porte-ar-d" <?php if($categorie=="porte-ar-d") echo "selected"?>>porte-ar-d</option>
						<option value="lunette-ar" <?php if($categorie=="lunette-ar") echo "selected"?>>lunette ar</option>
					</select>
					
					<button type="submit" value="Rechercher..." class="btn btn-success"><span class="glyphicon glyphicon-search"></span> Chercher...</button>
					&nbsp &nbsp
					<?php if($_SESSION['user']['role']=='ADMIN'){?>
						<a href="nouvelleMarchandise.php"><span class="glyphicon glyphicon-plus"></span> Nouvelle marchandise</a>
					<?php }?>
				</form>
			</div>

	    </div>
	</div>

	<div class="container">
		<div class="panel panel-primary">
			<div class="panel-heading">Listes des marchandises (<?php echo $nbrMarchandise?> Marchandises)</div>


			<div class="panel-body">
				<table class="table table-striped table-bordered">
					<thead>
						<tr>
							<th>Reference</th> <th>Designation</th> <th>Categorie</th> <th>Stock initial</th> <th>Prix unitaire</th> <th>Total</th> <?php if($_SESSION['user']['role']=='ADMIN'){?><th>Actions</th><?php } ?>
						</tr>
					</thead>

					<tbody>
							<?php while($marchandise=$resultatM->fetch()){ ?>

								<tr>
									<td><?php echo $marchandise['reference'];?> </td>
									<td><?php echo $marchandise['designation'];?> </td>
									<td><?php echo $marchandise['categorie'];?> </td>
									<td><?php echo $marchandise['stock_initial'];?> </td>
									<td><?php echo $marchandise['prix_unitaire'];?> DH</td>
									<td><?php echo $marchandise['total'];?> DH</td>
									<?php if($_SESSION['user']['role']=='ADMIN'){ ?>
										<td>
											<a  href="editerMarchandise.php?reference=<?php echo $marchandise['reference'];?>">
												<span class="glyphicon glyphicon-edit"></span>
											</a>
											&nbsp &nbsp

											<a onclick="return confirm('Etes vous sur vouloir supprimer la marchandise')"href="supprimerMarchandise.php?reference=<?php echo $marchandise['reference'];?>">
												<span class="glyphicon glyphicon-trash"></span>
											</a>
										</td>
									<?php } ?>
								</tr>

							<?php } ?>
					</tbody>

				</table>
					<div class="form-inline">
						<ul class="pagination pagination-md">
							<?php for($i=1; $i <= $nbrPage; $i++){ ?>
								   <li class="<?php if($page==$i){ echo 'active'; } ?>">
									   	<a href="marchandise.php?page=<?php echo $i;?>&nomM=<?php echo $nomM;?>&categorie=<?php echo $categorie;?>">
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