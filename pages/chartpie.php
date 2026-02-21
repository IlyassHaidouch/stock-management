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

$prediction_annee_suivante = $alpha * $annee_suivante + $beta;
$prediction_annee_dapres = $alpha * $annee_dapres + $beta;

// Préparation des données pour le graphique
$labels = array_column($data_sorties, 'annee');
$data = array_column($data_sorties, 'total_sorties');
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

    <div>
        <canvas id="myChart"></canvas>
    </div>

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
