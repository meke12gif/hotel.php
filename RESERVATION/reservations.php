<?php
session_start();

// Connexion à la base de données
$username = "root";
$servername = "localhost";
$password = "";
$dbname = "hotel";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("❌ Connexion échouée : " . $conn->connect_error);
}

// ✅ Fonction corrigée pour valider les dates
function validerDatesReservation($datedebut, $datefin) {
    $erreurs = [];

    $timestampDebut = strtotime($datedebut);
    $timestampFin   = strtotime($datefin);
    $timestampJour  = strtotime(date('Y-m-d'));

    // Vérification vide
    if (empty($datedebut)) {
        $erreurs[] = "La date de début est obligatoire.";
    }

    if (empty($datefin)) {
        $erreurs[] = "La date de fin est obligatoire.";
    }

    if (!empty($datedebut) && !empty($datefin)) {
        // ⛔ Date de début dans le passé
        if ($timestampDebut < $timestampJour) {
            $erreurs[] = "La date de début ne peut pas être dans le passé.";
        }

        // ⛔ Date de fin <= début
        if ($timestampFin <= $timestampDebut) {
            $erreurs[] = "La date de fin doit être après la date de début.";
        }

        // ⛔ Durée max 30 jours
        if (($timestampFin - $timestampDebut) > (30 * 24 * 60 * 60)) {
            $erreurs[] = "La durée maximale de réservation est de 30 jours.";
        }
    }

    return $erreurs;
}

// Traitement du formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 🔄 Récupération des données
    $DATEDEDEBUT   = trim($_POST['datedebut']);
    $DATEDEFIN     = trim($_POST['datefin']);
    $IDchambre     = intval($_POST['idchambre']);
    $IDclients     = intval($_POST['idclient']);
    $IDutilisateur = intval($_POST['idutilisateur']);
    $DATEDELARESE  = date('Y-m-d'); // Date de la réservation actuelle

    // ✅ Valider les dates avec notre fonction
    $erreurs = validerDatesReservation($DATEDEDEBUT, $DATEDEFIN);

    if (!empty($erreurs)) {
        foreach ($erreurs as $erreur) {
            echo "<div style='
                position: fixed;
                top: 20px;
                left: 50%;
                transform: translateX(-50%);
                background-color: #f44336;
                color: white;
                padding: 15px 25px;
                border-radius: 8px;
                font-weight: bold;
                font-size: 18px;
                box-shadow: 0px 0px 15px rgba(0,0,0,0.2);
                z-index: 9999;
            '>❗ $erreur</div>";
        }
        exit;
    }

    // ✅ Vérifier si la chambre est déjà réservée dans cette période
    $sql = "SELECT * FROM clients_chambre
            WHERE IDchambre = ?
            AND (datedebut < ? AND datefin > ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iss", $IDchambre, $DATEDEFIN, $DATEDEDEBUT);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        echo "<div style='
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #ff9800;
            color: white;
            padding: 16px 30px;
            border-radius: 8px;
            font-weight: bold;
            font-size: 17px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
            z-index: 10000;
            text-align: center;
        '>
            ⚠️ Désolé, la chambre est déjà réservée<br>
            📆 <strong>Du " . date("d/m/Y", strtotime($row['datedebut'])) . "</strong>
            au <strong>" . date("d/m/Y", strtotime($row['datefin'])) . "</strong>
        </div>";
        exit;
    }

    $stmt->close();

    // ✅ Insertion dans la base
    $sql = "INSERT INTO clients_chambre
            (datedebut, datefin, IDchambre, IDclients, IDutilisateur)
            VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssiis", $DATEDEDEBUT, $DATEDEFIN, $IDchambre, $IDclients, $IDutilisateur);

    if ($stmt->execute()) {
        echo "<div style='
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #4CAF50;
            color: white;
            padding: 15px 25px;
            border-radius: 8px;
            font-weight: bold;
            font-size: 18px;
            box-shadow: 0px 0px 15px rgba(0,0,0,0.2);
            z-index: 9999;
        '>✅ Réservation enregistrée avec succès !</div>";
    } else {
        echo "<div style='
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #f44336;
            color: white;
            padding: 15px 25px;
            border-radius: 8px;
            font-weight: bold;
            font-size: 18px;
            box-shadow: 0px 0px 15px rgba(0,0,0,0.2);
            z-index: 9999;
        '>❌ Erreur lors de l'enregistrement : " . htmlspecialchars($stmt->error) . "</div>";
    }

    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Ajouter une Réservation - Hôtel de Luxe</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />
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
  overflow-x: hidden;
}

body {
  background-image: url('../IMAGE/im3.jpg');
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
  background-image: inherit; /* Utilise l'image du body */
  background-size: cover;
  background-position: center;
  background-attachment: fixed;
  backdrop-filter: blur(12px);
  z-index: -1;
}

.container {
  max-width: 650px;
  width: 100%;
}

.card {
  padding: 45px; 
  background: rgba(0, 0, 0, 0.25);
  backdrop-filter: blur(20px) saturate(180%);
  -webkit-backdrop-filter: blur(20px) saturate(180%);
  border-radius: var(--border-radius);
  border: 1px solid var(--glass-border);
  box-shadow: 0 20px 40px var(--glass-shadow);
  padding: 40px;
  width: 100%;
  overflow: hidden;
  position: relative;
  animation: fadeIn 0.8s cubic-bezier(0.23, 1, 0.32, 1);
}

.card::before {
  content: '';
  position: absolute;
  top: -50%;
  left: -50%;
  width: 200%;
  height: 200%;
  background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, rgba(255,255,255,0) 70%);
  transform: rotate(30deg);
  pointer-events: none;
  animation: shimmer 8s infinite linear;
}

@keyframes shimmer {
  0% { transform: rotate(30deg) translateX(0%); }
  100% { transform: rotate(30deg) translateX(50%); }
}

@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(30px) scale(0.95);
  }
  to {
    opacity: 1;
    transform: translateY(0) scale(1);
  }
}

@keyframes float {
  0%, 100% { transform: translateY(0px); }
  50% { transform: translateY(-10px); }
}

@keyframes spin {
  to { transform: rotate(360deg); }
}

.header-icon {
padding: 45%;
  font-size: 3.5rem;
  color: var(--primary-light);
  margin-bottom: 20px;
  text-align: center;
  text-shadow: 0 4px 10px rgba(0,0,0,0.3);
  animation: float 3s ease-in-out infinite;
}

h2 {
  text-align: center;
  color: #fff;
  font-weight: 700;
  margin-bottom: 15px;
  font-size: 2.2rem;
  letter-spacing: 1px;
  text-shadow: 0 2px 8px rgba(0,0,0,0.3);
}

.text-muted {
  text-align: center;
  color: rgba(255, 255, 255, 0.9);
  margin-bottom: 30px;
  font-size: 1.1rem;
  line-height: 1.6;
  font-weight: 300;
}

.form-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 20px;
  margin-bottom: 25px;
}

.form-label {
  font-weight: 600;
  color: var(--primary-light);
  margin-bottom: 10px;
  display: block;
  font-size: 1rem;
  letter-spacing: 0.5px;
}

.input-icon {
  position: relative;
  width: 100%;
  margin-bottom: 25px;
}

.input-icon i {
  position: absolute;
  top: 50%;
  left: 18px;
  transform: translateY(-50%);
  color: var(--primary-light);
  font-size: 1.3rem;
  pointer-events: none;
  transition: var(--transition-speed);
  z-index: 2;
}

.input-icon input,
.input-icon select {
  width: 100%;
  padding: var(--input-padding);
  border: 2px solid rgba(255, 255, 255, 0.25);
  border-radius: 12px;
  font-size: 1.05rem;
  background-color: rgba(255, 255, 255, 0.15);
  color: #fff;
  transition: all var(--transition-speed);
  position: relative;
  z-index: 1;
  appearance: none;
  -webkit-appearance: none;
}

.input-icon input::placeholder {
  color: rgba(255, 255, 255, 0.7);
}

.input-icon input:focus,
.input-icon select:focus {
  border-color: var(--primary-light);
  box-shadow: 0 0 0 4px rgba(149, 213, 178, 0.4);
  outline: none;
  background-color: rgba(255, 255, 255, 0.25);
  transform: translateY(-2px);
}

.input-icon input:focus + i,
.input-icon select:focus + i {
  color: #fff;
  transform: translateY(-50%) scale(1.2);
  text-shadow: 0 0 10px rgba(149, 213, 178, 0.8);
}

.input-icon select {
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='20' height='20' fill='%2395d5b2' viewBox='0 0 16 16'%3E%3Cpath d='M8 12L2 6h12L8 12z'/%3E%3C/svg%3E");
  background-repeat: no-repeat;
  background-position: right 18px center;
  background-size: 18px;
}

.input-icon select option {
  background-color: var(--primary-dark);
  color: #fff;
  padding: 10px;
}

.room-info-card {
  background: rgba(255, 255, 255, 0.1);
  border: 1px solid rgba(255, 255, 255, 0.2);
  border-radius: 12px;
  padding: 20px;
  margin-top: 10px;
  backdrop-filter: blur(10px);
  transition: all 0.3s ease;
}

.room-info-card:hover {
  background: rgba(255, 255, 255, 0.15);
  transform: translateY(-2px);
}

.info-line {
  display: flex;
  justify-content: space-between;
  margin-bottom: 8px;
  font-size: 0.95rem;
}

.info-label {
  color: var(--primary-light);
  font-weight: 500;
}

.info-value {
  color: #fff;
  font-weight: 600;
}

.btn {
  background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
  color: white;
  border: none;
  padding: 18px 30px;
  border-radius: 50px;
  font-size: 1.1rem;
  font-weight: 600;
  cursor: pointer;
  width: 100%;
  transition: all 0.4s ease;
  box-shadow: 0 6px 20px rgba(45, 106, 79, 0.5);
  letter-spacing: 1px;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 12px;
  margin: 30px 0 20px;
  position: relative;
  overflow: hidden;
}

.btn::before {
  content: '';
  position: absolute;
  top: 0;
  left: -100%;
  width: 100%;
  height: 100%;
  background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
  transition: left 0.6s ease;
}

.btn:hover {
  background: linear-gradient(135deg, var(--primary-dark), var(--primary-color));
  transform: translateY(-4px);
  box-shadow: 0 10px 30px rgba(45, 106, 79, 0.7);
}

.btn:hover::before {
  left: 100%;
}

.btn:active {
  transform: translateY(-1px);
}

.btn-return {
  background: rgba(255, 255, 255, 0.15);
  color: white;
  border: 2px solid rgba(255, 255, 255, 0.3);
  padding: 15px 25px;
  border-radius: 50px;
  font-size: 1rem;
  font-weight: 600;
  cursor: pointer;
  width: 100%;
  transition: all 0.3s ease;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 10px;
  text-decoration: none;
  text-align: center;
  backdrop-filter: blur(10px);
}

.btn-return:hover {
  background: rgba(255, 255, 255, 0.25);
  border-color: rgba(255, 255, 255, 0.5);
  transform: translateY(-2px);
  color: white;
  text-decoration: none;
  box-shadow: 0 4px 15px rgba(255,255,255,0.2);
}

.notification {
  position: fixed;
  top: 30px;
  right: 30px;
  padding: 20px 25px;
  border-radius: 12px;
  background: linear-gradient(135deg, var(--primary-dark), var(--primary-color));
  color: white;
  box-shadow: 0 10px 30px rgba(0,0,0,0.3);
  transform: translateX(150%);
  transition: transform 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
  z-index: 1000;
  display: flex;
  align-items: center;
  gap: 15px;
  border-left: 5px solid var(--primary-light);
}

.notification.show {
  transform: translateX(0);
}

.duration-display {
  text-align: center;
  margin: 15px 0;
  font-size: 1.1rem;
  color: var(--primary-light);
  font-weight: 600;
}

.loading {
  display: inline-block;
  width: 20px;
  height: 20px;
  border: 3px solid rgba(255,255,255,.3);
  border-radius: 50%;
  border-top-color: #fff;
  animation: spin 1s ease-in-out infinite;
}

/* Responsive */
@media (max-width: 768px) {
  .form-grid {
    grid-template-columns: 1fr;
    gap: 15px;
  }

  .card {
    padding: 30px 20px;
  }

  h2 {
    font-size: 1.8rem;
  }

  .header-icon {
    font-size: 2.8rem;
  }

  .btn {
    padding: 16px 25px;
    font-size: 1rem;
  }
}

  </style>
</head>
<body>
  <div class="container">
    <div class="card">
      <div class="text-center">
        <i class="bi bi-calendar-plus header-icon"></i>
        <h2>Ajouter une Réservation</h2>
        <p class="text-muted">Renseignez les informations de la nouvelle réservation pour votre séjour</p>
      </div>

      <form method="POST" action="">
        <div class="form-grid">
          <div class="mb-3">
            <label for="datedebut" class="form-label">Date de Début</label>
            <div class="input-icon">
              <i class="bi bi-calendar-event"></i>
              <input type="date" id="datedebut" name="datedebut" required>
            </div>
          </div>

          <div class="mb-3">
            <label for="datefin" class="form-label">Date de Fin</label>
            <div class="input-icon">
              <i class="bi bi-calendar-event"></i>
              <input type="date" id="datefin" name="datefin" required>
            </div>
          </div>
        </div>

        <div class="duration-display" id="durationDisplay">
          Durée du séjour: <span id="durationValue">0</span> nuit(s)
        </div>

        <div class="mb-3">
          <label for="idchambre" class="form-label">Chambre</label>
          <div class="input-icon">
            <i class="bi bi-door-closed"></i>
            <select id="idchambre" name="idchambre" required>
              <option value="" disabled selected>Choisir une chambre</option>
              <?php
              $conn = new mysqli("localhost", "root", "", "hotel");
              $sql = "SELECT IDchambre, numerochambre FROM chambre";
              $result = $conn->query($sql);
              while ($row = $result->fetch_assoc()) {
                  echo '<option value="' . $row['IDchambre'] . '">Chambre ' . 
                       htmlspecialchars($row['numerochambre']) . '</option>';
              }
              $conn->close();
              ?>
            </select>
          </div>
          <div class="room-info-card" id="roomInfo">
            <div class="info-line">
              <span class="info-label">Type:</span>
              <span class="info-value" id="roomType">Sélectionnez une chambre</span>
            </div>
            <div class="info-line">
              <span class="info-label">Prix/nuit:</span>
              <span class="info-value" id="roomPrice">-</span>
            </div>
            <div class="info-line">
              <span class="info-label">Prix total:</span>
              <span class="info-value" id="totalPrice">-</span>
            </div>
          </div>
        </div>

        <div class="mb-3">
          <label for="idclient" class="form-label">Client</label>
          <div class="input-icon">
            <i class="bi bi-person"></i>
            <select id="idclient" name="idclient" required>
              <option value="" disabled selected>Choisir un client</option>
              <?php
              $conn = new mysqli("localhost", "root", "", "hotel");
              $sql = "SELECT IDclients, nomclient, emailclient FROM clients";
              $result = $conn->query($sql);
              while ($row = $result->fetch_assoc()) {
                  echo '<option value="' . $row['IDclients'] . '">' .
                      htmlspecialchars($row['nomclient']) .
                      ' (' . htmlspecialchars($row['emailclient']) . ')</option>';
              }
              $conn->close();
              ?>
            </select>
          </div>
        </div>

        <div class="mb-3">
          <label for="idutilisateur" class="form-label">Utilisateur</label>
          <div class="input-icon">
            <i class="bi bi-person-badge"></i>
            <select id="idutilisateur" name="idutilisateur" required>
              <option value="" disabled selected>Sélectionnez un utilisateur</option>
              <?php
              $conn = new mysqli("localhost", "root", "", "hotel");
              $sql = "SELECT IDutilisateur, nom FROM utilisateur";
              $result = $conn->query($sql);
              while ($user = $result->fetch_assoc()) {
                  echo '<option value="' . $user['IDutilisateur'] . '">' .
                      htmlspecialchars($user['nom']) . '</option>';
              }
              $conn->close();
              ?>
            </select>
          </div>
        </div>

        <button type="submit" class="btn" id="submitBtn">
          <i class="bi bi-plus-circle"></i> Ajouter la Réservation
        </button>
      </form>

      <a href="../accueil.php" class="btn-return">
        <i class="bi bi-arrow-left-circle"></i> Retour à l'accueil
      </a>
    </div>
  </div>

  <div class="notification" id="notification">
    <i class="bi bi-check-circle-fill"></i>
    <span>Réservation ajoutée avec succès!</span>
  </div>

  <script>
    // Données simulées pour les chambres (à remplacer par vos données réelles)
    const roomData = {
      <?php
      $conn = new mysqli("localhost", "root", "", "hotel");
      $sql = "SELECT c.IDchambre, t.grade, t.prix

              FROM chambre c
              JOIN typedechambre t ON c.IDtypedechambre = t.IDtypedechambre";
      $result = $conn->query($sql);
      while ($row = $result->fetch_assoc()) {
          echo $row['IDchambre'] . ": { type: '" . addslashes($row['grade']) . "', price: " . $row['prix'] . " },";
      }
      $conn->close();
      ?>

    };                                                                                                                                                                            
  


    // Calcul de la durée du séjour
    function calculateDuration() {
      const startDate = new Date(document.getElementById('datedebut').value);
      const endDate = new Date(document.getElementById('datefin').value);
      
      if (startDate && endDate && startDate < endDate) {
        const duration = Math.ceil((endDate - startDate) / (1000 * 60 * 60 * 24));
        document.getElementById('durationValue').textContent = duration;
        updateTotalPrice(duration);
        return duration;
      }
      document.getElementById('durationValue').textContent = '0';
      updateTotalPrice(0);
      return 0;
    }

    // Mise à jour du prix total
    function updateTotalPrice(duration) {
      const roomSelect = document.getElementById('idchambre');
      const roomId = roomSelect.value;
      
      if (roomId && roomData[roomId] && duration > 0) {
        const pricePerNight = roomData[roomId].price;
        const totalPrice = pricePerNight * duration;
        document.getElementById('totalPrice').textContent = totalPrice + ' €';
      } else {
        document.getElementById('totalPrice').textContent = '-';
      }
    }

    // Événements pour les dates
    document.getElementById('datedebut').addEventListener('change', function() {
      const endDate = document.getElementById('datefin');
      if (this.value) {
        endDate.min = this.value;
        calculateDuration();
      }
    });

    document.getElementById('datefin').addEventListener('change', calculateDuration);

    // Événement pour la sélection de chambre
    document.getElementById('idchambre').addEventListener('change', function() {
      const roomId = this.value;
      const roomInfo = roomData[roomId];
      
      if (roomInfo) {
        document.getElementById('roomType').textContent = roomInfo.type;
        document.getElementById('roomPrice').textContent = roomInfo.price + ' €';
        calculateDuration();
      } else {
        document.getElementById('roomType').textContent = 'Non disponible';
        document.getElementById('roomPrice').textContent = '-';
        document.getElementById('totalPrice').textContent = '-';
      }
    });

    // Validation du formulaire
    document.querySelector('form').addEventListener('submit', function(e) {
      const startDate = document.getElementById('datedebut').value;
      const endDate = document.getElementById('datefin').value;
      const room = document.getElementById('idchambre').value;
      const client = document.getElementById('idclient').value;
      const user = document.getElementById('idutilisateur').value;
      
      if (!startDate || !endDate || !room || !client || !user) {
        e.preventDefault();
        showNotification('Veuillez remplir tous les champs obligatoires', 'error');
        return false;
      }
      
      if (new Date(startDate) >= new Date(endDate)) {
        e.preventDefault();
        showNotification('La date de fin doit être après la date de début', 'error');
        return false;
      }
      
      // Animation de chargement
      const submitBtn = document.getElementById('submitBtn');
      submitBtn.innerHTML = '<div class="loading"></div> Traitement...';
      submitBtn.disabled = true;
      
      setTimeout(() => {
        submitBtn.innerHTML = '<i class="bi bi-check-circle"></i> Réservation réussie!';
      }, 1000);
    });

    // Fonction de notification améliorée
    function showNotification(message, type = 'success') {
      const notification = document.getElementById('notification');
      notification.innerHTML = type === 'success' ? 
        '<i class="bi bi-check-circle-fill"></i> ' + message :
        '<i class="bi bi-exclamation-triangle-fill"></i> ' + message;
      
      notification.style.background = type === 'success' ?
        'linear-gradient(135deg, #1b4332, #2d6a4f)' :
        'linear-gradient(135deg, #d00000, #dc2f02)';
      
      notification.classList.add('show');
      
      setTimeout(() => {
        notification.classList.remove('show');
      }, 4000);
    }

    // Initialisation
    document.addEventListener('DOMContentLoaded', function() {
      const today = new Date().toISOString().split('T')[0];
      document.getElementById('datedebut').min = today;
      
      // Afficher les données de la première chambre si disponible
      const firstRoom = document.querySelector('#idchambre option:not([disabled]):not([value=""])');
      if (firstRoom) {
        document.getElementById('idchambre').value = firstRoom.value;
        document.getElementById('idchambre').dispatchEvent(new Event('change'));
      }
    });
  </script>
</body>
</html>