<?php
session_start();

$username = "root";
$servername = "localhost";
$password = "";
$dbname = "hotel";
$errors = [];
// Connexion à la base de données
$conn = new mysqli($servername, $username, $password, $dbname);
// Vérification de la connexion
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupération des champs du formulaire
    $matricule        = trim($_POST['matricule']);
    $nom              = trim($_POST['nom']);
    $telephone       = trim($_POST['telephone']);
    $MDP             = $_POST['MDP'];
    $confirm_password = $_POST['confirm_password'];
    $nature          = trim($_POST['nature']);
    

    // Validation des champs
    if (empty($matricule)) {
        $errors[] = "Le matricule est requis";
    } elseif (!preg_match("/^[A-Za-z0-9]{3,20}$/", $matricule)) {
        $errors[] = "Le matricule doit contenir 3-20 caractères (lettres et chiffres uniquement)";
    }

    if (empty($nom)) {
        $errors[] = "Le nom est requis";
    } elseif (!preg_match("/^[A-Za-zÀ-ÿ\s]{2,50}$/", $nom)) {
        $errors[] = "Le nom doit contenir 2-50 caractères (lettres uniquement)";
    }

    if (empty($telephone)) {
        $errors[] = "Le téléphone est requis";
    } elseif (!preg_match("/^[0-9+\s\-()]{8,15}$/", $telephone)) {
        $errors[] = "Veuillez entrer un numéro de téléphone valide (8 à 15 chiffres)";
    }

    if (empty($MDP)) {
        $errors[] = "Le mot de passe est requis";
    } elseif (strlen($MDP) < 6) {
        $errors[] = "Le mot de passe doit contenir au moins 6 caractères";
    }

    if ($MDP !== $confirm_password) {
        $errors[] = "Les mots de passe ne correspondent pas";
    }

    if (empty($nature) || !in_array($nature, ['client', 'admin'])) {
        $errors[] = "Veuillez sélectionner une nature valide";
    }

    // Vérifier si le matricule existe déjà
    if (empty($errors)) {
        $stmt = $conn->prepare("SELECT IDutilisateur FROM utilisateur WHERE matricule = ?");
        $stmt->bind_param("s", $matricule);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $errors[] = "Le matricule existe déjà. Veuillez en choisir un autre.";
        }
        $stmt->close();
    }
    // Si pas d'erreurs, insérer dans la base de données
    if (empty($errors)) {
        $hashed_password = password_hash($MDP, PASSWORD_BCRYPT);
        $stmt = $conn->prepare("INSERT INTO utilisateur (matricule, nom, telephone, MDP, nature) VALUES (?, ?, ?, ?, ?)");
        if ($stmt) {
            $stmt->bind_param("sssss", $matricule, $nom, $telephone, $hashed_password, $nature);
            if ($stmt->execute()) {
                header("Location: compte.php?message=yes");
                exit();
            } else {
                $errors[] = "Erreur lors de l'exécution : " . $stmt->error;
            }
            $stmt->close();
        } else {
            $errors[] = "Erreur lors de la préparation : " . $conn->error;
        }
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inscription - Hôtel de Luxe</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
      :root {
  --primary-color: #2d6a4f;
  --primary-dark: #1b4332;
  --primary-light: #95d5b2;
  --accent-color: #ff9e44;
  --glass-bg: rgba(255, 255, 255, 0.1);
  --glass-border: rgba(255, 255, 255, 0.2);
  --glass-shadow: rgba(0, 0, 0, 0.25);
  --border-radius: 16px;
  --input-padding: 14px 14px 14px 45px;
  --transition-speed: 0.3s;
}

* {
  box-sizing: border-box;
  margin: 0;
  padding: 0;
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

html, body {
  height: 100%;
  
}

body {
  background-image: url('IMAGE/im2.jpg');
  background-size: cover;
  background-position: center;
  background-attachment: fixed;
  color: #fff;
  display: flex;
  align-items: center;
  justify-content: center;
  min-height: 100vh;
  padding: 20px;
  position: relative;
}

body::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: linear-gradient(135deg, rgba(45, 106, 79, 0.2), rgba(29, 53, 87, 0.2));
  backdrop-filter: blur(3px);
  z-index: -1;
}

.container {
  max-width: 500px;
  width: 100%;
}

.card {
       background: rgba(0, 0, 0, 0.1); 
  backdrop-filter: blur(16px) saturate(180%);
  -webkit-backdrop-filter: blur(16px) saturate(180%);
  border-radius: var(--border-radius);
  border: 1px solid var(--glass-border);
  box-shadow: 0 12px 30px var(--glass-shadow);
  padding: 30px;
  width: 100%;
  max-width: 100%;
  max-height: 90vh;
  position: relative;
  animation: fadeIn 0.6s ease-out;
}

.card::before {
  content: '';
  position: absolute;
  top: -50%;
  left: -50%;
  width: 200%;
  height: 200%;
  background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 60%);
  transform: rotate(30deg);
  pointer-events: none;
}

.header-icon {
  padding : 50%; 
  text-align: center;
  font-size: 2.8rem;
  color: var(--primary-light);
  margin-bottom: 15px;
  text-shadow: 0 2px 5px rgba(0,0,0,0.2);
}

h2 {
  text-align: center;
  color: #fff;
  font-weight: 700;
  margin-bottom: 10px;
  font-size: 1.8rem;
  letter-spacing: 0.5px;
}

.text-muted {
  text-align: center;
  color: rgba(255, 255, 255, 0.8);
  margin-bottom: 25px;
  font-size: 0.95rem;
  line-height: 1.5;
}

.form-label {
  font-weight: 600;
  color: var(--primary-light);
  margin-bottom: 8px;
  display: block;
  font-size: 0.95rem;
}

.input-icon {
  position: relative;
  width: 100%;
  margin-bottom: 20px;
}

.input-icon i {
  position: absolute;
  top: 50%;
  left: 15px;
  transform: translateY(-50%);
  color: var(--primary-light);
  font-size: 1.2rem;
  pointer-events: none;
  transition: var(--transition-speed);
  z-index: 2;
}

.input-icon input,
.input-icon select {
  width: 100%;
  box-sizing: border-box;
  padding: var(--input-padding);
  border: 1.5px solid rgba(255, 255, 255, 0.2);
  border-radius: var(--border-radius);
  font-size: 1rem;
  background-color: rgba(255, 255, 255, 0.12);
  color: #fff;
  transition: all var(--transition-speed);
  position: relative;
  z-index: 1;
  appearance: none;
  -webkit-appearance: none;
}

.input-icon select {
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%2395d5b2' viewBox='0 0 16 16'%3E%3Cpath d='M8 12L2 6h12L8 12z'/%3E%3C/svg%3E");
  background-repeat: no-repeat;
  background-position: right 15px center;
  background-size: 16px;
}

.input-icon input::placeholder,
.input-icon select option:first-child {
  color: rgba(255, 255, 255, 0.6);
}

.input-icon input:focus,
.input-icon select:focus {
  border-color: var(--primary-light);
  box-shadow: 0 0 0 3px rgba(149, 213, 178, 0.3);
  outline: none;
  background-color: rgba(255, 255, 255, 0.18);
}

.input-icon input:focus + i,
.input-icon select:focus + i {
  color: #fff;
  transform: translateY(-50%) scale(1.1);
}

.input-icon select option {
  background-color: var(--primary-dark);
  color: #fff;
}
 
.btn {
  background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
  color: white;
  border: none;
  padding: 14px 20px;
  border-radius: 50px;
  font-size: 1rem;
  font-weight: 600;
  cursor: pointer;
  width: 100%;
  transition: all 0.3s ease;
  box-shadow: 0 4px 15px rgba(45, 106, 79, 0.4);
  letter-spacing: 0.5px;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
}

.btn:hover {
  background: linear-gradient(135deg, var(--primary-dark), var(--primary-color));
  transform: translateY(-3px);
  box-shadow: 0 6px 20px rgba(45, 106, 79, 0.5);
}

.btn:active {
  transform: translateY(0);
}

.btn-return {
  background: rgba(255, 255, 255, 0.1);
  color: white;
  border: 1px solid rgba(255, 255, 255, 0.2);
  padding: 12px 20px;
  border-radius: 50px;
  font-size: 1rem;
  font-weight: 600;
  cursor: pointer;
  width: 100%;
  transition: all 0.3s ease;
  margin-top: 15px;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  text-decoration: none;
}

.btn-return:hover {
  background: rgba(255, 255, 255, 0.15);
  border-color: rgba(255, 255, 255, 0.3);
  transform: translateY(-2px);
  color: white;
  text-decoration: none;
}

.alert {
  background-color: rgba(255, 255, 255, 0.1);
  backdrop-filter: blur(10px);
  border: 1px solid rgba(255, 255, 255, 0.2);
  color: white;
  border-radius: var(--border-radius);
}

.alert-success {
  background-color: rgba(40, 167, 69, 0.2);
  border-color: rgba(40, 167, 69, 0.3);
}

.alert-danger {
  background-color: rgba(220, 53, 69, 0.2);
  border-color: rgba(220, 53, 69, 0.3);
}

.alert ul {
  margin-bottom: 0;
}

.text-link {
  color: var(--primary-light);
  text-decoration: none;
  transition: color 0.3s ease;
}

.text-link:hover {
  color: #fff;
  text-decoration: underline;
}

/* Animation d'entrée */
@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

/* ✅ Nouvelle classe pour disposer les inputs horizontalement */
.form-row {
  display: flex;
  gap: 15px;
  flex-wrap: wrap;
}

.form-row .input-icon {
  flex: 1;
  min-width: 120px;
}

/* Responsive */
@media (max-width: 576px) {
  .card {
    padding: 25px 20px;
  }

  h2 {
    font-size: 1.6rem;
  }

  .header-icon {
    font-size: 2.4rem;
  }
}

    </style>
   
</head>
<body>
  <div class="container">
    <div class="card">
      <div class="text-center">
        <i class="bi bi-person-plus header-icon"></i>
        <h2>Créer un compte</h2>
        <p class="text-muted">Rejoignez notre hôtel de luxe pour une expérience exceptionnelle</p>
      </div>
      
      <!-- Message de succès -->
      <?php if (isset($_GET['message']) && $_GET['message'] === 'yes'): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <strong>Succès !</strong> Inscription réussie ✅
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="filter: invert(1);"></button>
        </div>
      <?php endif; ?>

      <!-- Messages d'erreur -->
      <?php if (!empty($errors)): ?>
        <div class="alert alert-danger" role="alert">
          <strong>Erreurs détectées :</strong>
          <ul class="mb-0 mt-2">
            <?php foreach ($errors as $error): ?>
              <li><?php echo htmlspecialchars($error); ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endif; ?>

      <!-- Formulaire -->
      <form method="post" action="" id="registrationForm" novalidate> 
        <div class="mb-3">
          <label for="matricule" class="form-label">Matricule</label>
          <div class="input-icon">
            <i class="bi bi-person-badge"></i>
            <input type="text" class="form-control <?php echo !empty($errors) && isset($_POST['matricule']) ? (in_array('Le matricule est requis', $errors) || str_contains(implode(' ', $errors), 'matricule') ? 'is-invalid' : 'is-valid') : ''; ?>" 
                   id="matricule" name="matricule" required
                   pattern="[A-Za-z0-9]{3,20}"
                   title="Le matricule doit contenir 3-20 caractères alphanumériques"
                   value="<?php echo isset($_POST['matricule']) ? htmlspecialchars($_POST['matricule']) : ''; ?>">
          </div>
          <div class="invalid-feedback">
            Le matricule doit contenir 3-20 caractères (lettres et chiffres uniquement)
          </div>
        </div>

        <div class="mb-3">
          <label for="nom" class="form-label">Nom</label>
          <div class="input-icon">
            <i class="bi bi-person"></i>
            <input type="text" class="form-control <?php echo !empty($errors) && isset($_POST['nom']) ? (in_array('Le nom est requis', $errors) || str_contains(implode(' ', $errors), 'nom') ? 'is-invalid' : 'is-valid') : ''; ?>" 
                   id="nom" name="nom" required
                   pattern="[A-Za-zÀ-ÿ\s]{2,50}"
                   title="Le nom doit contenir 2-50 caractères (lettres uniquement)"
                   value="<?php echo isset($_POST['nom']) ? htmlspecialchars($_POST['nom']) : ''; ?>">
          </div>
          <div class="invalid-feedback">
            Le nom doit contenir 2-50 caractères (lettres uniquement)
          </div>
        </div>

        <div class="mb-3">
          <label for="telephone" class="form-label">Téléphone</label>
          <div class="input-icon">
            <i class="bi bi-telephone"></i>
            <input type="tel" class="form-control <?php echo !empty($errors) && isset($_POST['telephone']) ? (in_array('Le téléphone est requis', $errors) || str_contains(implode(' ', $errors), 'téléphone') ? 'is-invalid' : 'is-valid') : ''; ?>" 
                   id="telephone" name="telephone" required
                   pattern="[0-9+\s\-()]{8,15}" 
                   title="Veuillez entrer un numéro valide (8 à 15 chiffres)"
                   value="<?php echo isset($_POST['telephone']) ? htmlspecialchars($_POST['telephone']) : ''; ?>">
          </div>
          <div class="invalid-feedback">
            Veuillez entrer un numéro valide (8 à 15 chiffres)
          </div>
        </div>

        <div class="mb-3">
          <label for="MDP" class="form-label">Mot de passe</label>
          <div class="input-icon">
            <i class="bi bi-lock"></i>
            <input type="password" class="form-control <?php echo !empty($errors) && isset($_POST['MDP']) ? (str_contains(implode(' ', $errors), 'mot de passe') ? 'is-invalid' : 'is-valid') : ''; ?>" 
                   id="MDP" name="MDP" required
                   minlength="6" 
                   title="Le mot de passe doit contenir au moins 6 caractères">
          </div>
          
          <!-- Indicateur de force -->
          <div class="progress mt-2">
            <div class="progress-bar" role="progressbar" id="strength-bar" style="width: 0%"></div>
          </div>
          <small id="strength-text" class="text-muted">Force du mot de passe</small>
          
          <div class="invalid-feedback">
            Le mot de passe doit contenir au moins 6 caractères
          </div>
        </div>

        <div class="mb-3">
          <label for="confirm_password" class="form-label">Confirmer le mot de passe</label>
          <div class="input-icon">
            <i class="bi bi-lock-fill"></i>
            <input type="password" class="form-control <?php echo !empty($errors) && isset($_POST['confirm_password']) ? (str_contains(implode(' ', $errors), 'correspondent pas') ? 'is-invalid' : 'is-valid') : ''; ?>" 
                   id="confirm_password" name="confirm_password" required>
          </div>
          <div class="invalid-feedback">
            Les mots de passe ne correspondent pas
          </div>
        </div>

        <div class="mb-3">
          <label for="nature" class="form-label">Nature</label>
          <div class="input-icon">
            <i class="bi bi-person-rolodex"></i>
            <select class="form-select <?php echo !empty($errors) && isset($_POST['nature']) ? (in_array('Veuillez sélectionner une nature', $errors) || str_contains(implode(' ', $errors), 'nature') ? 'is-invalid' : 'is-valid') : ''; ?>" 
                    id="nature" name="nature" required>
              <option value="">-- Sélectionnez --</option>
              <option value="client" <?php echo isset($_POST['nature']) && $_POST['nature'] === 'client' ? 'selected' : ''; ?>>Client</option>
              <option value="admin" <?php echo isset($_POST['nature']) && $_POST['nature'] === 'admin' ? 'selected' : ''; ?>>Admin</option> 
            </select>
          </div>
          <div class="invalid-feedback">
            Veuillez sélectionner une nature
          </div>
        </div>

        <button type="submit" class="btn">
          <i class="bi bi-person-plus"></i> S'inscrire
        </button>
      </form>

      <!-- Lien vers connexion -->
      <div class="text-center mt-3">
        <small class="text-muted">
          Déjà un compte ? <a href="connexion.php" class="text-link">Se connecter</a>
        </small>
      </div>
    </div>
  </div>

  <script>
    // Variables
    const form = document.getElementById('registrationForm');
    const password = document.getElementById('MDP');
    const confirmPassword = document.getElementById('confirm_password');
    const strengthBar = document.getElementById('strength-bar');
    const strengthText = document.getElementById('strength-text');

    // Fonction pour afficher/masquer le mot de passe
    function togglePassword(inputId, iconId) {
      const input = document.getElementById(inputId);
      const icon = document.getElementById(iconId);
      const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
      input.setAttribute('type', type);
      icon.className = type === 'password' ? 'bi bi-eye' : 'bi bi-eye-slash';
    }

    // Vérification de la force du mot de passe
    password.addEventListener('input', function() {
      const value = this.value;
      let strength = 0;
      let percentage = 0;

      if (value.length >= 6) strength++;
      if (value.length >= 8) strength++;
      if (/[A-Z]/.test(value)) strength++;
      if (/[0-9]/.test(value)) strength++;
      if (/[^A-Za-z0-9]/.test(value)) strength++;

      percentage = (strength / 5) * 100;
      strengthBar.style.width = percentage + '%';
      strengthBar.className = 'progress-bar';
      
      if (strength <= 1) {
        strengthBar.classList.add('bg-danger');
        strengthText.textContent = 'Faible';
        strengthText.className = 'text-danger';
      } else if (strength <= 2) {
        strengthBar.classList.add('bg-warning');
        strengthText.textContent = 'Moyen';
        strengthText.className = 'text-warning';
      } else if (strength <= 3) {
        strengthBar.classList.add('bg-info');
        strengthText.textContent = 'Bon';
        strengthText.className = 'text-info';
      } else {
        strengthBar.classList.add('bg-success');
        strengthText.textContent = 'Excellent';
        strengthText.className = 'text-success';
      }
    });

    // Vérification de la correspondance des mots de passe
    function checkPasswordMatch() {
      if (confirmPassword.value && password.value !== confirmPassword.value) {
        confirmPassword.setCustomValidity('Les mots de passe ne correspondent pas');
        confirmPassword.classList.add('is-invalid');
        confirmPassword.classList.remove('is-valid');
      } else {
        confirmPassword.setCustomValidity('');
        confirmPassword.classList.remove('is-invalid');
        if (confirmPassword.value) {
          confirmPassword.classList.add('is-valid');
        }
      }
    }

    password.addEventListener('input', checkPasswordMatch);
    confirmPassword.addEventListener('input', checkPasswordMatch);

    // Validation en temps réel
    const inputs = form.querySelectorAll('input, select');
    inputs.forEach(input => {
      input.addEventListener('blur', function() {
        if (this.checkValidity()) {
          this.classList.remove('is-invalid');
          this.classList.add('is-valid');
        }
      });

      input.addEventListener('focus', function() {
        if (!this.classList.contains('is-invalid')) {
          this.classList.remove('is-valid');
        }
      });
    });
  </script>

</body>
</html>