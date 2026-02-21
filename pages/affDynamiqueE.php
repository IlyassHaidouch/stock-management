

<?php
// Database connection
require_once('identifier.php');
$dsn = "mysql:host=localhost;dbname=stock_management";
$username = "root";
$password = "";
$options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);

try {
    $pdo = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    die();
}

if(isset($_GET['reference'])){
    $reference = $_GET['reference'];

    // Get corresponding designation and stock_initial for that reference
    $stmt = $pdo->prepare("SELECT designation, categorie, prix_unitaire FROM marchandise WHERE reference=:reference");
    $stmt->execute(array(':reference' => $reference));

    // Check if the query executed successfully
    if ($stmt) {
        $row = $stmt->fetch();

        // Store the data in an array
        $data = array(
            'designation' => $row["designation"],
            'categorie' => $row["categorie"],
            'coutA' => $row["prix_unitaire"]
        );
        // Send the data in JSON format
        echo json_encode($data);
    } else {
        echo "Error executing query";
    }
}
?>
