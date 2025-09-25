<?php
session_start();

$username = "root";
$servername = "localhost";
$password = "";
$dbname = "hotel";

// Connexion à la BDD
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connexion échouée : " . $conn->connect_error);
}

$erreur = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $matricule = $_POST['matricule'];
    $MDP = $_POST['MDP'];

    $sql = "SELECT * FROM utilisateur WHERE matricule = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $matricule);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($MDP, $user['MDP'])) {
            // ✅ Connexion réussie - stocker les infos utiles
            $_SESSION['IDutilisateur'] = $user['IDutilisateur'];
            $_SESSION['nom_utilisateur'] = $user['nom'];
            $_SESSION['matricule'] = $user['matricule'];
            $_SESSION['nature'] = $user['nature'];

            header("Location: accueil.php");
            exit();
        } else {
            $erreur = "Mot de passe incorrect.";
        }
    } else {
        $erreur = "Matricule non trouvé.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Connexion - Hôtel</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card shadow p-4">
          <h2 class="text-center mb-4">Connexion</h2>
          
          <!-- Affichage des erreurs -->
          <?php if ($erreur): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($erreur); ?></div>
          <?php endif; ?>

          <!-- Formulaire de connexion -->
          <form method="post" action="">
            <div class="mb-3">
              <label for="matricule" class="form-label">Matricule</label>
              <input type="text" class="form-control" id="matricule" name="matricule" required>
            </div>
            <div class="mb-3">
              <label for="MDP" class="form-label">Mot de passe</label>
              <input type="password" class="form-control" id="MDP" name="MDP" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Se connecter</button>
          </form>

          <p class="text-center mt-3">
            Pas de compte ? <a href="compte.php">Inscrivez-vous ici</a>
          </p>
        </div>
      </div>
    </div>
  </div> 