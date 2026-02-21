<?php
		require('identifier.php');

		require('connexion.php');
  
		$year = isset($_GET['year']) ? $_GET['year'] : "";
		$month = isset($_GET['month'])?$_GET['month']:"";
		$index_table = isset($_GET['index'])?$_GET['index']:0;
		

		$index="";
		if($index_table==1)  $index="marchandise"; 
		if($index_table==2)  $index="entrees";
		if($index_table==3)  $index="sorties";
	
        

		echo "index : $index";
		echo "year : $year";


		if(isset($_POST['btnExport'])){
          	  $datatable = $pdo->prepare("SELECT * FROM $index");
			  $datatable->execute(array($index));    	 
          	  $count = $datatable->rowCount();
          	  echo "count  : $count";
          	  if($count>=1)
          	  {
          	  	$file = "export/" . strtotime("now") . ".csv";
          	  	$openFile = fopen($file,"w");
          	  	echo "Export Processing<br>";
          	  	$alldata = $datatable->fetch(PDO::FETCH_ASSOC);
                $line=0;
                $a=0;
				$label="";
				if($index_table==1){
					foreach($alldata as $name => $value){
						$line++;      	  		
						if($line<6 && $line!=1)
						{
							$label .= $name .";";
						}
						
						else
						{
							if($a==1){
							$label .=  $name. "\n";
							break;
							}
							$a=1;
						}
											
						}
				}

				if($index_table==2 || $index_table==3){
					foreach($alldata as $name => $value){
						$line++;      	  		
						if($line<7 && $line!=1)
						{
							$label .= $name .";";
						}
						
						else
						{
							if($a==1){
							$label .=  $name. "\n";
							break;
							}
							$a=1;
						}
											
						}
				}
          	  	
                
                $datatable2 = $pdo->prepare("SELECT * FROM $index WHERE YEAR(_date) = ? AND MONTH(_date) = ? ");
				$datatable2->execute([$year, $month]);

				if($index_table==1){
					$datavalue="";
					while($alldata2 = $datatable2->fetch()){

						$datavalue .= $alldata2['designation'] . ";" .$alldata2['categorie'] . ";" . $alldata2['stock_initial'] .  ";" . $alldata2['prix_unitaire'] .  ";" . $alldata2['total'] . "\n";
					}

					fputs($openFile,$label . $datavalue);
					$msg = "<a href='$file'>Télécharger votre fichier Excel </a>"; 
				}

				if($index_table==2){
					$datavalue="";
					while($alldata2 = $datatable2->fetch()){

						$datavalue .= $alldata2['_date'] . ";" .$alldata2['designation'] . ";" .$alldata2['categorie'] . ";" . $alldata2['cout_achat'] .  ";" . $alldata2['quantite'] .  ";" . $alldata2['total'] . "\n";
					}

					fputs($openFile,$label . $datavalue);
					$msg = "<a href='$file'>Télécharger votre fichier Excel </a>"; 
				}

				if($index_table==3){
					$datavalue="";
					while($alldata2 = $datatable2->fetch()){

						$datavalue .= $alldata2['_date'] . ";" .$alldata2['designation'] . ";" .$alldata2['categorie'] . ";" . $alldata2['prix_vente'] .  ";" . $alldata2['quantite'] .  ";" . $alldata2['total'] . "\n";
					}

					fputs($openFile,$label . $datavalue);
					$msg = "<a href='$file'>Télécharger votre fichier Excel </a>"; 
				}
				       	  	
          	  }
          	  else
          	  {
          	  	 $msg =  "vous n'avez aucune donnée dans mysql!!";
          	  }

            }

            $requete_filieres="SELECT * FROM marchandise";
			$result_requete_filieres=$pdo->query($requete_filieres);
			$toutes_les_filieres=$result_requete_filieres->fetchAll();
 		

	
									
?>
<!DOCTPE html>
<html>
	<head>
		<meta charset="utf-8"/>
		<title> Les etudiants </title> 
		<link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
		<link rel="stylesheet" type="text/css" href="../css/font-awesome.min.css">
		<link rel="stylesheet" type="text/css" href="../css/monStyle.css">
		<script src="../js/jquery-1.10.2.js"></script>
		<script src="../js/bootstrap.min.js"></script>
		
	</head>
		
	<body>
	
		<?php include('menu.php'); ?>
		<br><br>
		<div class="container">

			
			<div class="panel panel-primary margetop">
				<div class="panel-heading">Personnaliser l'exportation </div>
				<div class="panel-body">

<!-- ******************** Début Formulaire de recherche des stagiaires ***************** -->
					<form class="form-inline" action="impression.php" >
				
					    <label> Année : </label>

						<select class="form-control" name="year" id="year">
							<?php for ($y = 2021; $y <= date('Y'); $y++) : ?>
								<option value="<?php echo $y; ?>" <?php if ($y == $year) echo "selected"; ?>><?php echo $y; ?></option>
							<?php endfor; ?>
                		</select>
						&nbsp
						<label> Mois : </label>
						<select class="form-control" name="month" id="month">
							<option value="1" <?php if($month==1){ echo "selected";} ?> >Janvier</option>
							<option value="2" <?php if($month==2){ echo "selected";} ?> >Février</option>
							<option value="3" <?php if($month==3){ echo "selected";} ?> >Mars</option>
							<option value="4" <?php if($month==4){ echo "selected";} ?> >Avril</option>
							<option value="5" <?php if($month==5){ echo "selected";} ?> >Mai</option>
							<option value="6" <?php if($month==6){ echo "selected";} ?> >Juin</option>
							<option value="7" <?php if($month==7){ echo "selected";} ?> >Juillet</option>
							<option value="8" <?php if($month==8){ echo "selected";} ?> >Août</option>
							<option value="9" <?php if($month==9){ echo "selected";} ?> >Septembre</option>
							<option value="10" <?php if($month==10){ echo "selected";} ?> >Octobre</option>
							<option value="11" <?php if($month==11){ echo "selected";} ?> >Novembre</option>
							<option value="12" <?php if($month==12){ echo "selected";} ?> >Décembre</option>
                		</select>
                        &nbsp
						

						<label> À Imprimer : </label>
							<label class="radio-inline">
								<input type="radio"
										value="1"
										<?php if($index_table==1) echo 'checked'?>
										name="index">Marchandises
							</label>
							<label class="radio-inline">
								<input  type="radio" 
										value="2"
										<?php if($index_table==2) echo 'checked'?>
										name="index">Entrées
							</label>
							<label class="radio-inline">
								<input type="radio"
										value="3"
										<?php if($index_table==3) echo 'checked'?>
										name="index">Sorties
							</label>
						
						&nbsp
						<button class="btn btn-primary"> 
							<span class="glyphicon glyphicon-search"></span>
						</button>
					</form>
<!-- ******************** Fin Formulaire de recherche des stagiaires ***************** -->

			
				</div>
			</div>
			
			
            <div class="panel panel-primary">
		        <div class="panel-heading">--------------</div>
		        <div class="panel-body">

            <form method="POST" action="" class="form">
                
                
                <div class="form-group">
                    <label for="nom" > Exporter les données dans un fichier excel :  </label>
                    <br />
                        <input type="submit" name="btnExport" value="Export data into excel" class="btn btn-success">
                </div>

                  <?php 
                    if(isset($msg) AND !empty($msg))
                    {
                        echo $msg;
                    }

                   ?>                          
        
                
            
            </form>
        
        </div>

    </div>
    
</div>
	</body>
</html>




