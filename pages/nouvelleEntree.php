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
				<form method="post" action="insertEntree.php" class="form">

                    <div class="form-group">
						<label for="date">Date:</label>
						<input type="date" name="date"  class="form-control" id="date">
					</div>

					<div class="form-group">
						<label for="reference">Référence:</label>
						<input type="string" name="reference" placeholder="reference"  id="reference" class="form-control" onkeyup="fetchData()">

					</div>

					<div class="form-group">
						<label for="designation">Désignation:</label>
						<input type="text" name="designation"  placeholder="Désignation" id="designation" class="form-control">
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
						<label for="coutA">Coût d'achat:</label>
						<input type="number" step="0.01" name="coutA" placeholder="Coût d'achat" id="coutA" class="form-control">
					</div>

					<div class="form-group">
						<label for="quantite">Quantité:</label>
						<input type="number" name="quantite" placeholder="Quantité" id="quantite" class="form-control">  
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

		<script src="../js/nouvelleEntree.js"></script>
		 
			
	
		