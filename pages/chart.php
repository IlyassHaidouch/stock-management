<?php
// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "stock_management";

// création de la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Récupérer les données des sorties de la base de données
$sql_sorties = "SELECT YEAR(_date) as annee, SUM(total) as total_sorties FROM sorties GROUP BY YEAR(_date) ORDER BY YEAR(_date)";
$result_sorties = mysqli_query($conn, $sql_sorties);

// Stocker les données dans un tableau
$data_sorties = array();
while ($row_sorties = mysqli_fetch_assoc($result_sorties)) {
    $data_sorties[] = $row_sorties;
}

// Calculer la moyenne des années et des sorties
$total_annees = count($data_sorties);
$total_sorties = array_sum(array_column($data_sorties, 'total_sorties'));
$moyenne_annees = $total_annees > 0 ? ($total_annees + 1) / 2 : 0;
$moyenne_sorties = $total_sorties > 0 ? $total_sorties / $total_annees : 0;

// Calculer la pente de la ligne de régression et l'ordonnée à l'origine
$numerateur = 0;
$denominateur = 0;
foreach ($data_sorties as $row_sorties) {
    $annee = $row_sorties['annee'];
    $sorties = $row_sorties['total_sorties'];
    $numerateur += ($annee - $moyenne_annees) * ($sorties - $moyenne_sorties);
    $denominateur += pow($annee - $moyenne_annees, 2);
}
$pente = $numerateur / $denominateur;
$ordonnee_origine = $moyenne_sorties - ($pente * $moyenne_annees);

// Faire une prédiction pour les années à venir
$annee_actuelle = date('Y');
$annee_suivante = $annee_actuelle + 1;
$annee_dapres = $annee_actuelle + 2;

$prediction_annee_suivante = round($pente * $annee_suivante + $ordonnee_origine, 2);
$prediction_annee_dapres = round($pente * $annee_dapres + $ordonnee_origine, 2);

// Préparer les données pour le graphique
$labels = array();
$data = array();
foreach ($data_sorties as $row_sorties) {
    $annee = $row_sorties['annee'];
    $sorties = $row_sorties['total_sorties'];
    $labels[] = $annee;
    $data[] = $sorties;
}
$labels[] = $annee_suivante;
$data[] = $prediction_annee_suivante;
$labels[] = $annee_dapres;
$data[] = $prediction_annee_dapres;

?>
 <!DOCTYPE html>
<html>
<head>
  <title>Prévisions des sorties</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

  <h1>Prévisions des sorties</h1>

  <div class="" height="300" width="400">
    <canvas id="myChart"></canvas>
  </div>

  <script>
    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?php echo json_encode(array_column($data_sorties, 'annee')); ?>.concat([<?php echo $annee_suivante; ?>, <?php echo $annee_dapres; ?>]),
            datasets: [{
                label: 'Sorties',
                data: <?php echo json_encode(array_column($data_sorties, 'total_sorties')); ?>.concat([<?php echo $prediction_annee_suivante; ?>, <?php echo $prediction_annee_dapres; ?>]),
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

