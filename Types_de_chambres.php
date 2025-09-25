<?php
session_start();

$username = "root";
$servername = "localhost";
$password = "";
$dbname = "hotel";

// Connexion à la base de données
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

$erreurs = "";

// Inclusion du fichier connexionbd.php 
// (ATTENTION : ça fait peut-être double emploi avec la connexion ci-dessus !)
include 'connexionbd.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupération des données
    $grade = $_POST['grade'] ?? '';
    $prix = $_POST['prix'] ?? '';

    // Validation simple
    if (!empty($grade) && !empty($prix)) {
        // Préparer la requête
        $sql = "INSERT INTO typedechambre (grade, prix) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            // Utilisation correcte de bind_param
            $stmt->bind_param("sd", $grade, $prix); // 's' pour string, 'd' pour double (prix)

            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                header("Location: chambre/chambres.php?message=yes");
                exit();
            } else {
                echo "Erreur lors de l'insertion : " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Erreur de préparation de la requête : " . $conn->error;
        }
    } else {
        echo "Tous les champs sont obligatoires."; 
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Type de Chambre - Hôtel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
      
:root {
  --primary-color: #2d6a4f;
  --primary-dark: #d8dad9ff;
  --primary-light: #95d5b2;
  --accent-color: #f6e05e;
  --bg-color: #f1f8f5;
  --text-color: #1e1e1e;
  --text-muted: #555;
  --glass-bg: rgba(255, 255, 255, 0.2);
  --glass-border: rgba(255, 255, 255, 0.3);
  --glass-shadow: rgba(0, 0, 0, 0.15);
  --border-radius: 10px;
  --input-padding: 12px 12px 12px 40px;
  --transition-speed: 0.3s;
}

* {
  box-sizing: border-box;
  margin: 0;
  padding: 0;
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

body {
  background-image: url('IMAGE/im2.jpg');
  background-size: cover;
  background-position: center;
  color: var(--text-color);
  padding: 40px 20px;
  min-height: 100vh;
  backdrop-filter: blur(1.5px);
}

.container {
  max-width: 500px; /* Réduction taille carte */
  margin: auto;
}

.card {
  background:rgba(0, 0, 0, 0.39);
  backdrop-filter: blur(12px);
  -webkit-backdrop-filter: blur(12px);
  border-radius: var(--border-radius);
  border: 1px solid var(--glass-border);
  box-shadow: 0 8px 24px var(--glass-shadow);
  padding: 24px; /* Moins de padding */
}

.header-icon {
  font-size: 2.4rem;
  color: white ;
  margin-bottom: 12px;
  text-align: center;
}

h2 {
  text-align: center;
  color: white ;
  font-weight: bold;
  margin-bottom: 10px;
}

.text-muted {
  text-align: center;
  color: white;
  margin-bottom: 20px;
  font-size: 0.9rem;
}

.form-label {
  font-weight: 600;
  color: var(--primary-dark); /* Changement couleur label */
  margin-bottom: 6px;
  display: block;
}

.input-icon {
  position: relative;
  margin-bottom: 16px;
}

.input-icon i {
  position: absolute;
  top: 50%;
  left: 12px;
  transform: translateY(-50%);
  color: var(--primary-light);
  font-size: 1.1rem;
  pointer-events: none;
}

input[type="text"],
input[type="number"],
input[type="email"],
input[type="tel"],
input[type="date"],
select {
  width: 100%;
  padding: var(--input-padding);
  border: 1.5px solid var(--primary-light);
  border-radius: var(--border-radius);
  font-size: 1rem;
  background-color: rgba(255, 255, 255, 0.95);
  color: var(--text-color);
  transition: border-color var(--transition-speed);
}

input:focus,
select:focus {
  border-color: var(--primary-color);
  box-shadow: 0 0 4px var(--primary-light);
  outline: none;
}

/* ✅ Nouveau style bouton */
.btn {
  background-color: var(---glass-bg);

  color: white;
  border: none;
  padding: 12px 18px;
  border-radius: 50px;
  font-size: 1rem;
  font-weight: 600;
  cursor: pointer;
  width: 100%;
  transition: background-color var(--primary-color), transform 0.2s;
}

.btn:hover {
  background-color: black ;
  transform: translateY(-2px);
}

.return-link {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  margin-top: 18px;
  text-decoration: none;
  color: var(--primary-dark);
  font-weight: 500;
  font-size: 0.95rem;
}

.return-link:hover {
  text-decoration: underline;
}

/* Alertes */
.alert {
  padding: 12px 16px;
  border-radius: var(--border-radius);
  margin-bottom: 20px;
  border: 1px solid;
}

.alert-success {
  background-color: #d4edda;
  color: #155724;
  border-color: #c3e6cb;
}

.alert-error {
  background-color: #f8d7da;
  color: #721c24;
  border-color: #f5c6cb;
}

@media (max-width: 600px) {
  .card {
    padding: 20px;
  }
  .header-icon {
    font-size: 2.2rem;
  }
}

    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="header-icon">
                <i class="fas fa-bed"></i>
            </div>
            
            <h2>Ajouter un Type de Chambre</h2>
            <p class="text-muted">Renseignez les informations du nouveau type de chambre</p>
            
            <?php if (!empty($message)): ?>
                <div class="alert alert-<?php echo $message_type; ?>">
                    <i class="fas <?php echo $message_type === 'success' ? 'fa-check-circle' : 'fa-exclamation-triangle'; ?>"></i>
                    <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="" novalidate>
                <div class="input-icon">
                    <i class="fas fa-star"></i>
                    <label class="form-label" for="grade">Grade</label>
                    <input type="text" 
                           id="grade" 
                           name="grade" 
                           placeholder="Ex: Standard, Luxe, Suite..." 
                           value="<?php echo htmlspecialchars($grade ?? ''); ?>"
                           maxlength="50"
                           required>
                </div>
                
                <div class="input-icon">
                    <i class="fas fa-euro-sign"></i>
                    <label class="form-label" for="prix">Prix (€)</label>
                    <input type="number" 
                           id="prix" 
                           name="prix" 
                           placeholder="Ex: 89.99" 
                           step="0.01" 
                           min="0"
                           value="<?php echo htmlspecialchars($prix ?? ''); ?>"
                           required>
                </div>
                
                <button type="submit" class="btn">
                    <i class="fas fa-plus"></i>
                    Ajouter le Type de Chambre
                </button>
            </form>
            
            <a href="accueil.php" class="return-link">
                <i class="fas fa-arrow-left" style="margin-right: 8px;"></i>
                Retour à la gestion des chambres
            </a>
        </div>
    </div>
    <script>
// Apparition de la carte avec animation
document.addEventListener("DOMContentLoaded", () => {
    const card = document.querySelector(".card");
    card.style.opacity = 0;
    card.style.transform = "translateY(50px)";
    setTimeout(() => {
        card.style.transition = "all 0.8s ease";
        card.style.opacity = 1;
        card.style.transform = "translateY(0)";
    }, 200);
});

// Glow animé sur les inputs
const inputs = document.querySelectorAll("input, select");
inputs.forEach(input => {
    input.addEventListener("focus", () => {
        input.style.transition = "0.4s";
        input.style.boxShadow = "0 0 12px rgba(45, 106, 79, 0.6)";
    });
    input.addEventListener("blur", () => {
        input.style.boxShadow = "none";
    });
});

// Effet ripple sur le bouton
document.querySelectorAll(".btn").forEach(btn => {
    btn.addEventListener("click", function(e) {
        let ripple = document.createElement("span");
        ripple.classList.add("ripple");
        this.appendChild(ripple);

        let x = e.clientX - this.offsetLeft;
        let y = e.clientY - this.offsetTop;
        ripple.style.left = `${x}px`;
        ripple.style.top = `${y}px`;

        setTimeout(() => {
            ripple.remove();
        }, 600);
    });
});

// Animation des alertes (slide + fade)
const alertBox = document.querySelector(".alert");
if (alertBox) {
    alertBox.style.opacity = 0;
    alertBox.style.transform = "translateY(-20px)";
    setTimeout(() => {
        alertBox.style.transition = "all 0.6s ease";
        alertBox.style.opacity = 1;
        alertBox.style.transform = "translateY(0)";
    }, 300);

    // Disparition auto après 4 sec
    setTimeout(() => {
        alertBox.style.transition = "all 0.8s ease";
        alertBox.style.opacity = 0;
        alertBox.style.transform = "translateY(-20px)";
    }, 4000);
}
</script>

</body>
</html>