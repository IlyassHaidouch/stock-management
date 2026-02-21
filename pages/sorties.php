<?php
	require_once('identifier.php');
	require_once("connexion.php");
	$nomM = isset($_GET['nomM'])?$_GET['nomM']:"";
	$categorie = isset($_GET['categorie'])?$_GET['categorie']:"all";

	 
	$size = isset($_GET['size'])?$_GET['size']:6;
	$page = isset($_GET['page'])?$_GET['page']:1;
	$offset = ($page-1)*$size;

	if($categorie=="all"){
		$requete = "select * from sorties where designation like '%$nomM%' limit $size offset $offset";
		$requeteCount = "select count(*) countM from sorties where designation like '%$nomM%'";
	}
	else{
		$requete = "select * from sorties where designation like '%$nomM%' and categorie='$categorie' limit $size offset $offset";
		$requeteCount = "select count(*) countM from sorties where designation like '%$nomM%' and categorie='$categorie'";
	}
	
	$resultatM = $pdo->query($requete);
	$resultatCount = $pdo->query($requeteCount);
	$tabCount = $resultatCount->fetch();
	$nbrSorties = $tabCount['countM']; //nbrSorties c-à-dire nombre de ventes ou plutôt nombre d'enregistrement

	$reste = $nbrSorties%$size;
	if($reste===0){
		$nbrPage = $nbrSorties/$size;
	}
	else{
		$nbrPage = floor($nbrSorties/$size)+1; //la partie entière d'un nombre décimal
	}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../css/monstyle.css">
	<title>gestion des sorties</title>
</head>
<body>  
   
	<?php include('menu.php'); ?>
	<div class="container">
		<div class="panel panel-success margetop">
			<div class="panel-heading">Rechercher les sorties(les ventes)</div>

			<div class="panel-body">
				<form method="get" action="sorties.php" class="form-inline">
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
					<?php if($_SESSION['user']['role']=='ADMIN'){?><a href="nouvelleSortie.php"><span class="glyphicon glyphicon-plus"></span> Nouvelle marchandise</a><?php } ?>

				</form>
			</div>

	    </div>
	</div>

	<div class="container">
		<div class="panel panel-primary">
			<div class="panel-heading">Listes des sorties (<?php echo $nbrSorties;?> Marchandises)</div>


			<div class="panel-body">
				<table class="table table-striped table-bordered">
					<thead>
						<tr>
							<th>Numéro</th> <th>Date</th> <th>Référence</th> <th>Désignation</th> <th>Catégorie</th><th>Quantité</th> <th>Prix de vente</th> <th>Total</th><?php if($_SESSION['user']['role']=='ADMIN'){?><th>Actions</th><?php } ?>
						</tr>
					</thead>

					<tbody>
							<?php while($marchandise=$resultatM->fetch()){ ?>

								<tr>
									<td><?php echo $marchandise['numero'];?> </td>
									<td><?php echo $marchandise['_date'];?> </td>
									<td><?php echo $marchandise['reference'];?> </td>
									<td><?php echo $marchandise['designation'];?> </td>
									<td><?php echo $marchandise['categorie'];?> </td>
									<td><?php echo $marchandise['quantite'];?> </td>
									<td><?php echo $marchandise['prix_vente'].' DH';?> </td>
									<td><?php echo $marchandise['total'].' DH';?> </td>
									<?php if($_SESSION['user']['role']=='ADMIN'){?>
										<td>
											<a  href="editerSortie.php?numero=<?php echo $marchandise['numero'];?>">
												<span class="glyphicon glyphicon-edit"></span>
											</a>
											&nbsp &nbsp

											<a onclick="return confirm('Etes vous sur vouloir supprimer la marchandise')" href="supprimerSortie.php?numero=<?php echo $marchandise['numero'];?>">
												<span class="glyphicon glyphicon-trash"></span>
											</a>
										</td>
									<?php } ?>
								</tr>

							<?php } ?>
					</tbody>

				</table>
					<div>
						<ul class="pagination pagination-md">
							<?php for($i=1; $i <= $nbrPage; $i++){ ?>
								   <li class="<?php if($page==$i){ echo 'active'; } ?>">
									   	<a href="sorties.php?page=<?php echo $i;?>&categorie=<?php echo $categorie;?>">
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