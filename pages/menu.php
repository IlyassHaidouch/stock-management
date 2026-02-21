<?php
require_once('identifier.php');
?>
<nav class="navbar navbar-inverse navbar-fixed-top">
    
    	<div class="navbar-header">
    		<a href="../index.php" class="navbar-brand">Gestion de Stocks</a>
    	</div>
		<ul class="nav navbar-nav">

			<li><a href="marchandise.php">Marchandises</a></li>

			<li><a href="entrees.php">Entrées</a></li>

			<li><a href="sorties.php">Sorties</a></li>

			<li><a href="inventaire.php">Inventaires</a></li>

			<?php if($_SESSION['user']['role']=='ADMIN'){?>
				<li><a href="utilisateurs.php">Utilisateurs</a></li>
			<?php }?>

			<li><a href="chartTest.php">Statistique</a></li>

			<li><a href="impression.php">Export DATA</a></li>

			
		</ul>

		<ul class="nav navbar-nav navbar-right">
			<li><a href="editerUtilisateur?idU=<?php echo $_SESSION['user']['iduser'];?>"><i class="glyphicon glyphicon-user"></i> <?php echo $_SESSION['user']['login']; ?></a></li>
			<li><a href="seDeconnecter"><i class="glyphicon glyphicon-log-out"></i> Se deconnecter</a></li>
	 	</ul>
    
</nav>

	 

