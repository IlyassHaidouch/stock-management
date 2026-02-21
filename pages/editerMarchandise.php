<?php   
	require_once('identifier.php');
    require_once('connexion.php');
    $reference = isset($_GET['reference'])?$_GET['reference']:0;
    $requete = "select * from marchandise where reference = '$reference'";
    $resultat = $pdo->query($requete);
    $marchandise = $resultat->fetch();
    $designation = $marchandise['designation'];
    $categorie = strtolower($marchandise['categorie']);
    $stockI = $marchandise['stock_initial'];
    $prixU = $marchandise['prix_unitaire'];
    $total = $marchandise['total'];
	
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../css/monstyle.css">
	<title>nouvelle Marchandise</title>
</head>
<body>

	<?php include('menu.php'); ?>

	<div class="container">
		<div class="panel panel-primary margetop">
			<div class="panel-heading">Edition de la marchandise</div>
			<div class="panel-body">
				<form method="post" action="updateMarchandise.php" class="form">

					<div class="form-group">
						<label for="categorie">Référence de la Marchandise : <?php echo $reference; ?></label>
						<input type="hidden" name="reference" value="<?php echo $reference; ?>" class="form-control">
					</div>

					<div class="form-group">
						<label for="categorie">Désignation:</label>
						<input type="text" name="designation" value="<?php echo $designation;?>" class="form-control">
					</div>

					<div class="form-group">
						<label for="categorie">Catégorie:</label>
						<select name="categorie" class="form-control" id="categorie" >
							<option value="Pare-brise" <?php if($categorie=="Pare-brise"){echo "selected";}?>>pare-brise</option>
							<option value="porte-av-g" <?php if($categorie=="porte-av-g"){echo "selected";}?>>porte-av-g</option>
							<option value="porte-av-d" <?php if($categorie=="porte-av-d"){echo "selected";}?>>porte-av-d</option>
							<option value="porte-ar-g" <?php if($categorie=="porte-ar-g"){echo "selected";}?>>porte-ar-g</option>
							<option value="porte-ar-d" <?php if($categorie=="porte-ar-d"){echo "selected";}?>>porte-ar-d</option>
							<option value="lunette-ar" <?php if($categorie=="lunette-ar"){echo "selected";}?>>lunette ar</option>
						</select>
					</div>

					<div class="form-group">
						<label for="categorie">Stock Initial:</label>
						<input type="number" name="stockI" id="stockI" placeholder="Stock initial" value="<?php echo $stockI;?>" class="form-control">
					</div>

					<div class="form-group">
						<label for="categorie">Prix Unitaire:</label>
						<input type="number" name="prixU" id="prixU" step="0.01" placeholder="Prix unitaire" value="<?php echo $prixU;?>" class="form-control">  
					</div>

					<div class="form-group">
						<label for="total">Total:</label>
						<input type="text" name="total"  id="total" placeholder="total" value="<?php echo $total;?>" class="form-control" >  
					</div>
					
					<button type="submit" value="Rechercher..." class="btn btn-success"><span class="glyphicon glyphicon-save"></span> Enregistrer</button>
					&nbsp &nbsp
					
				</form>
			</div>
		</div>
	</div>

</body>
</html>
				<script src="../js/editerM.js"></script>