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

// Préparation des données pour les seuils de risque
$seuils = array(0.01, 0.05, 0.1);
$colors = array('rgba(255, 0, 0, 1)', 'rgba(255, 165, 0, 1)', 'rgba(255, 255, 0, 1)');

$datasets = array();

// Données de base (sorties)
$datasets[] = array(
    'label' => 'Sorties',
    'data' => $sorties,
    'backgroundColor' => 'rgba(54, 162, 235, 0.2)',
    'borderColor' => 'rgba(54, 162, 235, 1)',
    'borderWidth' => 1
);

// Générer les ensembles de données pour les seuils de risque
// Générer les ensembles de données pour les seuils de risque
for ($i = 0; $i < count($seuils); $i++) {
    if (isset($seuils[$i])) {
        $seuil = $seuils[$i];
        $color = $colors[$i];

        $dataset = array(
            'label' => 'Seuil de risque ' . ($seuil * 100) . '%',
            'data' => array_fill(0, $n, $seuil),
            'borderColor' => $color,
            'borderWidth' => 1,
            'borderDash' => array(5, 5),
            'fill' => false
        );

        $datasets[] = $dataset;
    }
}


// Générer les graphiques
// Générer les graphiques
$charts = array();

foreach ($seuils as $i => $seuil) {
    $chartData = array(
        'labels' => $annees,
        'datasets' => array($datasets[0], $datasets[$i+1])
    );

    $charts[] = $chartData;
}



?>

<!DOCTYPE html>
<html>
<head>
    <title>Prévisions des sorties</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

    <h1>Prévisions des sorties</h1>

    <?php foreach ($charts as $index => $chartData): ?>
        <div class="" height="300" width="400">
            <canvas id="myChart<?php echo $index; ?>"></canvas>
        </div>

        <script>
            var ctx<?php echo $index; ?> = document.getElementById('myChart<?php echo $index; ?>').getContext('2d');
            var myChart<?php echo $index; ?> = new Chart(ctx<?php echo $index; ?>, {
                type: 'line',
                data: <?php echo json_encode($chartData); ?>,
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
    <?php endforeach; ?>

</body>
</html>
