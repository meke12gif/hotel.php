<?php
// modifier_client.php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hotel";
$conn = new mysqli($servername, $username, $password, $dbname);

include '../connexionbd.php '; // connexion à la base

if ($conn->connect_error) {
    die("Connexion échouée : " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['IDclients'])) {
    $IDclients = intval($_GET['IDclients']);
    $sql = "SELECT * FROM clients WHERE IDclients = $IDclients";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $client = $result->fetch_assoc();
    } else {
        echo "Client non trouvé.";
        exit;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") { 
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $numero = $_POST['numero'];

    $sql = "UPDATE clients SET nomclient=?, emailclient=?, numeroclient=? WHERE IDclients=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $nom, $email, $numero, $IDclients);

    if ($stmt->execute()) {
        header("Location: liste_clients.php"); // Reviens à la liste
        exit;
    } else {
        echo "Erreur lors de la mise à jour.";
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier le client</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center" style="height: 100vh;">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg">
                <div class="card-body">
                    <h3 class="card-title text-center mb-4">Modifier le client</h3>

                    <?php if (isset($client)): ?>
                    <form method="post">
                    

                        <div class="mb-3">
                            <label class="form-label">Nom</label>
                            <input type="text" name="nom" class="form-control" value="<?= htmlspecialchars($client['nomclient']) ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($client['emailclient']) ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Numéro</label>
                            <input type="text" name="numero" class="form-control" value="<?= htmlspecialchars($client['numeroclient']) ?>" required>
                        </div>

                        <button type="submit" class="btn btn-success w-100">Mettre à jour</button>
                        <a href="listeclient.php" class="btn btn-outline-secondary w-100 mt-2">Annuler</a>
                    </form>
                    <?php else: ?>
                        <div class="alert alert-danger text-center">
                            Client non trouvé.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>