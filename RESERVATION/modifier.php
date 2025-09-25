<?php
$conn = new mysqli("localhost", "root", "", "hotel");
if ($conn->connect_error) {
    die("❌ Connexion échouée : " . $conn->connect_error);
}

// Récupération des clés
if (isset($_GET['idclient'], $_GET['idchambre'], $_GET['datedebut'])) {
    $idclient = (int) $_GET['idclient'];
    $idchambre = (int) $_GET['idchambre'];
    $datedebut = $conn->real_escape_string($_GET['datedebut']);

    // Formulaire soumis
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $nouvelle_datedebut = $_POST['datedebut'];
        $nouvelle_datefin = $_POST['datefin'];

        $sql = "UPDATE clients_chambre 
                SET datedebut = '$nouvelle_datedebut', datefin = '$nouvelle_datefin'
                WHERE IDclients = $idclient AND IDchambre = $idchambre AND datedebut = '$datedebut'";

        if ($conn->query($sql) === TRUE) {
            header("Location: liste_reservations.php?message=modifie");
            exit();
        } else {
            echo "❌ Erreur : " . $conn->error;
        }
    }

    // Charger les infos à modifier
    $sql = "SELECT * FROM clients_chambre 
            WHERE IDclients = $idclient AND IDchambre = $idchambre AND datedebut = '$datedebut'";
    $result = $conn->query($sql);

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
    } else {
        die("❌ Réservation introuvable.");
    }

} else {
    die("❌ Paramètres manquants.");
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier une réservation</title>
</head>
<body>
    <h2>✏️ Modifier la réservation</h2>
    <form method="POST">
        <label>Date Début:</label><br>
        <input type="date" name="datedebut" value="<?= $row['datedebut'] ?>" required><br><br>

        <label>Date Fin:</label><br>
        <input type="date" name="datefin" value="<?= $row['datefin'] ?>" required><br><br>

        <button type="submit">💾 Enregistrer</button>
        <a href="liste_reservations.php">↩️ Annuler</a>
    </form>
</body>
</html>
