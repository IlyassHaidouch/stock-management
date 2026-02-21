<?php
	require_once('identifier.php');
    require_once('connexion.php');
    $numero = isset($_GET['numero'])?$_GET['numero']:0;
    $requete = "select * from entrees where numero='$numero'";
    $resultat = $pdo->query($requete);
    $marchandise = $resultat->fetch();
    $date = isset($marchandise['_date'])?$marchandise['_date']:"la cle date n'existe pas dans le tableau";
    $reference = $marchandise['reference'];
    $designation = $marchandise['designation'];
    $categorie = strtolower($marchandise['categorie']);
    $coutAchat = $marchandise['cout_achat'];
    $quantite = $marchandise['quantite'];
    $total = $marchandise['total'];
	
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../css/monstyle.css">
	<title>Edition d'entrées</title>
</head>
<body>

	<?php include('menu.php'); ?>
    
	<div class="container">
		<div class="panel panel-primary margetop">
			<div class="panel-heading">Nouvelle Opération (Entrées)</div>
			<div class="panel-body">
				<form method="post" action="updateEntrees.php" class="form">

                    <div class="form-group">
                        <label>Numéro : <?php echo $numero; ?></label>
						<input type="hidden" name="numero" id="numero" value="<?php echo $numero;?>" class="form-control">
                    </div>
					
                    
					<div class="form-group">
                        
						
						<label for="categorie">Référence : </label>
						<input type="text" name="reference" value="<?php echo $reference; ?>" class="form-control">
					</div>

                    <div class="form-group">
						<label for="date">Date:</label>
						<input type="date" name="date" value="<?php echo $date;?>" class="form-control">
					</div>

					<div class="form-group">
						<label for="designation">Désignation:</label>
						<input type="text" name="designation" value="<?php echo $designation;?>" class="form-control" id="designation">
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
						<label for="coutAchat">Coût d'achat:</label>
						<input type="number" step="0.01" name="coutA" placeholder="Coût d'achat" value="<?php echo $coutAchat;?>" id="coutA" class="form-control">
					</div>

					<div class="form-group">
						<label for="quantite">Quantité:</label>
						<input type="number" name="quantite" placeholder="Quantité" value="<?php echo $quantite;?>" id="quantite" class="form-control">  
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

<script src="../js/editerE.js"></script>