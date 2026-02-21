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
	<title>nouvelle Marchandise</title>
</head>
<body>

	<?php include('menu.php'); ?>

	<div class="container">
		<div class="panel panel-primary margetop">
			<div class="panel-heading">Veuillez saisir les données de la nouvelle marchandise</div>
			<div class="panel-body">
				<form method="post" action="insertMarchandise.php" class="form">

					<div class="form-group">
						<label for="categorie">Référence:</label>
						<input type="text" name="reference" placeholder="reference" class="form-control">
					</div>

					<div class="form-group">
						<label for="categorie">Désignation:</label>
						<input type="text" name="designation" placeholder="Désignation" class="form-control">
					</div>

					<div class="form-group">
						<label for="categorie">Catégorie:</label>
						<select name="categorie" class="form-control" id="categorie" >
							<option value="Pare-brise">pare-brise</option>
							<option value="porte-av-g">porte-av-g</option>
							<option value="porte-av-d">porte-av-d</option>
							<option value="porte-ar-g">porte-ar-g</option>
							<option value="porte-ar-d">porte-ar-d</option>
							<option value="lunette-ar">lunette ar</option>
						</select>
					</div>

					<div class="form-group">
						<label for="categorie">Stock Initial:</label>
						<input type="number" name="stockI"  id="stockI" placeholder="Stock initial" class="form-control">
					</div>

					<div class="form-group">
						<label for="categorie">Prix Unitaire:</label>
						<input type="number" name="prixU" id="prixU" step="0.01" placeholder="Prix unitaire" class="form-control">  
					</div>

					<div class="form-group">
						<label for="total">Total:</label>
						<input type="text" name="total"  id="total" class="form-control" >  
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