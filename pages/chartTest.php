<?php
require_once('connexion.php');
require_once('identifier.php');
 



$year = isset($_POST['year']) ? $_POST['year'] : date('Y');

$month = isset($_POST['month']) ? $_POST['month'] : date('M');

    
    $sqlS = "SELECT categorie, SUM(quantite) as total_entrees FROM entrees WHERE MONTH(_date) = :month GROUP BY categorie";
    $stmtS = $pdo->prepare($sqlS);
    $stmtS->execute(['month' => $month]);
    $resultS = $stmtS->fetchAll(PDO::FETCH_ASSOC);

    // Créer des tableaux de données pour le graphique
    $labelsS = array();
    $dataS = array();
    foreach ($resultS as $rowS) {
    $labelsS[] = $rowS["categorie"];
    $dataS[] = $rowS["total_entrees"];
  }



    // require_once('connexion.php');
    $sqlE = "SELECT categorie, SUM(quantite) as total_sorties FROM sorties WHERE MONTH(_date) = :month GROUP BY categorie";
    $stmtE = $pdo->prepare($sqlE);
    $stmtE->execute(['month' => $month]);
    $resultE = $stmtE->fetchAll(PDO::FETCH_ASSOC);
    
    // Créer des tableaux de données pour le graphique
    $labelsE = array();
    $dataE = array();
    foreach ($resultE as $rowE) {
        $labelsE[] = $rowE["categorie"];
        $dataE[] = $rowE["total_sorties"];
      }




?>
<?php
    require_once('connexion.php');
    $year = isset($_POST['year']) ? $_POST['year'] : date('Y'); // initialiser à l'année courante si $_POST['year'] n'est pas définie
    $months = array("Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre");
    
    
    $total_sorties = array();
    $stmt = $pdo->prepare("SELECT MONTH(_date) as month, SUM(total) as total_sorties FROM sorties WHERE YEAR(_date) = ? GROUP BY MONTH(_date)");
    $stmt->execute([$year]);

    while($result = $stmt->fetch()) {
        $total_sorties[$result['month']] = $result['total_sorties'];
    }

    $dataSL = array();
    for ($i = 1; $i <= 12; $i++) {
        $dataSL[] = $total_sorties[$i] ?? 0;
    }


    $total_entrees = array();
    $stmt = $pdo->prepare("SELECT MONTH(_date) as month, SUM(total) as total_entrees FROM entrees WHERE YEAR(_date) = ? GROUP BY MONTH(_date)");
    $stmt->execute([$year]);

    while($result = $stmt->fetch()) {
        $total_entrees[$result['month']] = $result['total_entrees'];
    }

    $dataEL = array();
    for ($i = 1; $i <= 12; $i++) {
        $dataEL[] = $total_entrees[$i] ?? 0;
    }
     
?>

<!-- Ce code effectue la régression linéaire à partir des données de sorties, 
calcule les coefficients alpha et beta, 
puis fait des prédictions pour les deux années prochaines. 
Les résultats sont affichés dans un graphique de type line chart 
en utilisant la bibliothèque Chart.js. -->


<?php
    // Connexion à la base de données
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "stock_management";

    // Création de la connexion
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Récupérer les données des sorties de la base de données
    $sql_sorties = "SELECT YEAR(_date) as annee, SUM(total) as total_sorties FROM sorties GROUP BY YEAR(_date) ORDER BY YEAR(_date)";
    $result_sorties = mysqli_query($conn, $sql_sorties);

    // Stocker les données dans un tableau
    $data_sorties = array();
    while ($row_sorties = mysqli_fetch_assoc($result_sorties)) {
        $data_sorties[] = $row_sorties;
    }

    // Préparation des données pour la régression linéaire
    $annees = array();
    $sorties = array();
    foreach ($data_sorties as $row_sorties) {
        $annees[] = $row_sorties['annee'];
        $sorties[] = $row_sorties['total_sorties'];
    }

    // Effectuer la régression linéaire
    $n = count($annees);
    $sum_x = array_sum($annees);
    $sum_y = array_sum($sorties);
    $sum_xx = array_sum(array_map(function ($x) { return $x * $x; }, $annees));
    $sum_xy = array_sum(array_map(function ($x, $y) { return $x * $y; }, $annees, $sorties));

    $alpha = ($n * $sum_xy - $sum_x * $sum_y) / ($n * $sum_xx - $sum_x * $sum_x); // coefficient alpha
    $beta = ($sum_y - $alpha * $sum_x) / $n; // coefficient beta

    // Prédictions pour les deux années prochaines
    $annee_actuelle = end($annees);
    $annee_suivante = $annee_actuelle + 1;
    $annee_dapres = $annee_actuelle + 2;
    $annee_dapres_suivante = $annee_actuelle + 3;

    $prediction_annee_suivante = $alpha * $annee_suivante + $beta;
    $prediction_annee_dapres = $alpha * $annee_dapres + $beta;
    $prediction_annee_dapres_suivante = $alpha * $annee_dapres_suivante + $beta;

    // Préparation des données pour le graphique
    $labels = array_column($data_sorties, 'annee');
    $data = array_column($data_sorties, 'total_sorties');
    $labels[] = $annee_suivante;
    $data[] = $prediction_annee_suivante;
    $labels[] = $annee_dapres;
    $data[] = $prediction_annee_dapres;
    $labels[] = $annee_dapres_suivante;
    $data[] = $prediction_annee_dapres_suivante;
?>








<!DOCTYPE html>
<html>
<head>
  <title>Total des sorties par catégorie</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/monstyle.css">
  <style>
    .Charts {
        display: flex;
        justify-content: space-around;
    }
    .Charts canvas {
        width: 400px;
        height: 400px;
    }


  </style>
</head>
<body>

    <?php include('menu.php');?>
    
    <h1 class="text-center margetop">Total des entrées et sorties par catégorie :</h1>
        <form method="post">
            <div class="text-center">
                <label  for="month">Mois :</label>
                <select class="" name="month" id="month">
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
                <input type="submit" value="Afficher le graphique" class="btn btn-primary">
            </div>
        </form>

        <br><br>
        <div class="Charts">
            <div class="chartE" height="300" width="400">
                <canvas id="myChartE"></canvas>
            </div>

            <div class="chartS" height="300" width="400">
                <canvas id="myChartS" ></canvas>
            </div>
        </div>




        <h1 class="text-center">Graphique des entrées et sorties par mois pour l'année<?php echo " : $year";?></h1>

        <form method="POST">
            <div class="text-center">
                <label for="year">Année :</label>
                <select name="year" id="year">
                    <?php for ($y = 2021; $y <= date('Y'); $y++) : ?>
                        <option value="<?php echo $y; ?>" <?php if ($y == $year) echo "selected"; ?>><?php echo $y; ?></option>
                    <?php endfor; ?>
                </select>
                <input type="submit" value="Afficher le graphique" class="btn btn-primary">
            </div>
        </form>
        <br><br>
        <div class="Charts">
            <div class="" height="300" width="400">
                <canvas id="myChartSL"></canvas>
            </div>
            <div class="" height="300" width="400">
                <canvas id="myChartEL"></canvas>
            </div>
        </div>



        <h1 class="text-center">Prévisions des sorties pour les deux années prochaines</h1>

        <div class="Charts">
            <div class="" height="300" width="400">
                <canvas id="myChart"></canvas>
            </div>
        </div>

    


 
    <script>
        var ctx = document.getElementById('myChartE').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: <?php echo json_encode($labelsE); ?>,
                datasets: [{
                    data: <?php echo json_encode($dataE); ?>,
                    backgroundColor: [
                    'rgba(255, 99, 132, 0.5)',
                    'rgba(54, 162, 235, 0.5)',
                    'rgba(255, 206, 86, 0.5)',
                    'rgba(75, 192, 192, 0.5)',
                    'rgba(153, 102, 255, 0.5)',
                    'rgba(255, 159, 64, 0.5)',
                    'rgba(255, 99, 132, 0.5)',
                    'rgba(54, 162, 235, 0.5)',
                    'rgba(255, 206, 86, 0.5)',
                    'rgba(75, 192, 192, 0.5)',
                    'rgba(153, 102, 255, 0.5)',
                    'rgba(255, 159, 64, 0.5)'
                    ],
                    borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    title: {
                        display: true,
                        text: 'Total des sorties par catégorie',
                        color: 	'#FFFFF'
                    }
                }
            }
        });
    </script>

    <script>
        var ctx = document.getElementById('myChartS').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: <?php echo json_encode($labelsS); ?>,
                datasets: [{
                    data: <?php echo json_encode($dataS); ?>,
                    backgroundColor: [
                    'rgba(255, 99, 132, 0.5)',
                    'rgba(54, 162, 235, 0.5)',
                    'rgba(255, 206, 86, 0.5)',
                    'rgba(75, 192, 192, 0.5)',
                    'rgba(153, 102, 255, 0.5)',
                    'rgba(255, 159, 64, 0.5)',
                    'rgba(255, 99, 132, 0.5)',
                    'rgba(54, 162, 235, 0.5)',
                    'rgba(255, 206, 86, 0.5)',
                    'rgba(75, 192, 192, 0.5)',
                    'rgba(153, 102, 255, 0.5)',
                    'rgba(255, 159, 64, 0.5)'
                    ],
                    borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    title: {
                        display: true,
                        text: 'Total des entrées par catégorie',
                        color: 	'#FFFFF'
                    }
                }
            }
        });
    </script>

    

  




    <script>
        var ctx = document.getElementById('myChartSL').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($months); ?>,
                datasets: [{
                    label: 'Sorties par mois',
                    data: <?php echo json_encode($dataSL); ?>,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    </script>


    <script>
        var ctx = document.getElementById('myChartEL').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($months); ?>,
                datasets: [{
                    label: 'Entrees par mois',
                    data: <?php echo json_encode($dataEL); ?>,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    </script>


        <script>
            var ctx = document.getElementById('myChart').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: <?php echo json_encode($labels); ?>,
                    datasets: [{
                        label: 'Sorties',
                        data: <?php echo json_encode($data); ?>,
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });
        </script>

</body>
</html>
 
</body>
</html>
