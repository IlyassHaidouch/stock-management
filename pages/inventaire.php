<?php
	require_once('identifier.php');
	require_once('connexion.php');
	$requete = "SELECT m.reference, m.designation, m.categorie, m.stock_initial, IFNULL(e.entrees, 0) AS entrees, IFNULL(s.sorties, 0) AS sorties, COALESCE(m.stock_initial + IFNULL(e.entrees, 0) - IFNULL(s.sorties, 0), 0) AS stock_final
	FROM marchandise AS m
	LEFT JOIN (
	  SELECT reference, SUM(quantite) AS entrees
	  FROM entrees
	  GROUP BY reference
	) AS e ON m.reference = e.reference
	LEFT JOIN (
	  SELECT reference, SUM(quantite) AS sorties
	  FROM sorties
	  GROUP BY reference
	) AS s ON m.reference = s.reference;
";
	$resultatM = $pdo->query($requete);
	

	function estNegative($stock_final){
		if($stock_final < 0){
			return 0;
		}
		else{
			echo $stock_final;
		}
	}
	
	function statute($stock_final){
		
		if($stock_final >= 2){
			echo '<p class="vert">stock normal</p>';
		}

		elseif($stock_final==0 OR $stock_final < 0){
			echo '<p class="rouge">stock non disponible</p>';
		}
		
		else {
			echo '<p class="jaune">stock faible</p>';
		}
	}
	
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../css/monstyle.css">
	<style>
		.vert {
			color : green;
			font-weight : bold;
		}

		.rouge {
			color : red;
			font-weight : bold;
		}

		.jaune {
			color : orange;
			font-weight : bold;
		}

		
	</style>
	<title>Inventaire</title>
</head>
<body>

	<?php include('menu.php'); ?>

	<div class="container">
		<div class="panel panel-success margetop">
			<div class="panel-heading">Rechercher..</div>
			<div class="panel-body">le contenu du panneau</div>
	    </div>
	</div>

	<div class="container">
		<div class="panel panel-primary">
			<div class="panel-heading">l'inventaire</div>
			<div class="panel-body">
			<table class="table table-striped table-bordered">
					<thead>
						<tr>
							<th>Reference</th> <th>Designation</th> <th>Categorie</th> <th>Stock initial</th> <th>Entrées</th> <th>Sorties</th><th>Stock final</th> <th>Statue</th>
						</tr>
					</thead>

					<tbody>
							<?php while($marchandise=$resultatM->fetch()){ ?>

								<tr>
									<td><?php echo $marchandise['reference'];?> </td>
									<td><?php echo $marchandise['designation'];?> </td>
									<td><?php echo $marchandise['categorie'];?> </td>
									<td><?php echo $marchandise['stock_initial'];?> </td>
									<td><?php echo $marchandise['entrees'];?> </td>
									<td><?php echo $marchandise['sorties'];?> </td>
									<td><?php echo estNegative($marchandise['stock_final']);?> </td>
									<td><?php statute($marchandise['stock_final'])?></td>
									
								</tr>

							<?php } ?>
					</tbody>

				</table>
			</div>
		</div>
	</div>

</body>
</html>