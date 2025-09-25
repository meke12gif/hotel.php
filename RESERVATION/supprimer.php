<?php
// Connexion à la base
$conn = new mysqli("localhost", "root", "", "hotel");
if ($conn->connect_error) {
    die("❌ Connexion échouée : " . $conn->connect_error);
}

// Vérifie que les 3 clés sont bien passées en GET
if (isset($_GET['idclient'], $_GET['idchambre'], $_GET['datedebut'])) {
    $idclient = (int) $_GET['idclient'];
    $idchambre = (int) $_GET['idchambre'];
    $datedebut = $conn->real_escape_string($_GET['datedebut']);

    // Supprimer la réservation
    $sql = "DELETE FROM clients_chambre 
            WHERE IDclients = $idclient 
              AND IDchambre = $idchambre 
              AND datedebut = '$datedebut'";

    if ($conn->query($sql) === TRUE) {
        // ✅ Ajout dans l'historique (optionnel)
        // $idutilisateur = 1; // à récupérer de la session
        // $conn->query("INSERT INTO historique (date, action, detaille, IDutilisateur)
        //              VALUES (NOW(), 'Suppression réservation', 'Client ID: $idclient, Chambre ID: $idchambre, Date: $datedebut', $idutilisateur)");

        // Redirection avec message
        header("Location: liste_reservations.php?message=success");
        exit();
    } else {
        echo "❌ Erreur de suppression : " . $conn->error;
    }

} else {
    echo "⚠️ Paramètres manquants.";
}
?>
