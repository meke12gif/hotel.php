<?php
session_start();

$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "hotel";

// Connexion à la base
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("❌ Connexion échouée : " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Récupération des données envoyées par le formulaire
    $numerochambre   = intval($_POST['numerochambre']);
    $etage           = intval($_POST['etage']);
    $IDtypedechambre = intval($_POST['IDtypedechambre']);

    // Vérifier si la chambre existe déjà
    $check = $conn->prepare("SELECT COUNT(*) FROM chambre WHERE numerochambre = ?");
    $check->bind_param("i", $numerochambre);
    $check->execute();
    $check->bind_result($count);
    $check->fetch();
    $check->close();

    if ($count > 0) {
        // Chambre déjà existante
        echo "⚠️ Erreur : Le numéro de chambre $numerochambre   a deja un grade .";
    } else {
        // Insertion de la nouvelle chambre
        $stmt = $conn->prepare("INSERT INTO chambre (numerochambre, etage, IDtypedechambre) VALUES (?, ?, ?)");
        $stmt->bind_param("iii", $numerochambre, $etage, $IDtypedechambre);

        if ($stmt->execute()) {
            // Redirection en cas de succès
            header("Location: ../accueil.php?message=yes");
            exit();
        } else {
            echo "❌ Erreur lors de l'insertion : " . $stmt->error;
        }

        $stmt->close();
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ajouter une Chambre - Hôtel de Luxe</title> 
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
      background-image: url('../IMAGE/pexels-pixabay-261102.jpg');
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
      backdrop-filter: blur(8px);
      z-index: -1;
    }

    .container {
      max-width: 500px;
      width: 100%;
    }

    .card {
      background: rgba(0, 0, 0, 0.39);
      backdrop-filter: blur(7px) saturate(200%);
      -webkit-backdrop-filter: blur(16px) saturate(180%);
      border-radius: var(--border-radius);
      border: 1px solid var(--glass-border);
      box-shadow: 0 12px 30px var(--glass-shadow);
      padding: 30px;
      width: 100%;
      position: relative;
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

    .price-info {
      display: block;
      margin-top: 5px;
      font-size: 0.85rem;
      color: var(--primary-light);
      font-style: italic;
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
      margin-bottom: 15px;
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
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      text-decoration: none;
      text-align: center;
    }

    .btn-return:hover {
      background: rgba(255, 255, 255, 0.15);
      border-color: rgba(255, 255, 255, 0.3);
      transform: translateY(-2px);
      color: white;
      text-decoration: none;
    }

    .notification {
      position: fixed;
      top: 20px;
      right: 20px;
      padding: 15px 20px;
      border-radius: 8px;
      background: var(--primary-dark);
      color: white;
      box-shadow: 0 5px 15px rgba(0,0,0,0.2);
      transform: translateX(150%);
      transition: transform 0.4s ease;
      z-index: 1000;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .notification.show {
      transform: translateX(0);
    }

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
    .card {
      animation: fadeIn 0.6s ease-out;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="card">
      <div class="text-center">
        <div class="header-icon">
          <i class="bi bi-door-closed"></i>
        </div>
        <h2>Ajouter une Chambre</h2>
        <p class="text-muted">Renseignez les informations de la nouvelle chambre</p>
      </div>
      
      <form method="POST" action="">
        <div class="mb-3">
          <label for="numerochambre" class="form-label">Numéro de Chambre</label>
          <div class="input-icon">
            <i class="bi bi-123"></i>
            <input type="number" id="numerochambre" name="numerochambre" placeholder="Ex: 101" required>
          </div>
        </div>
        
        <div class="mb-3">
          <label for="etage" class="form-label">Étage</label>
          <div class="input-icon">
            <i class="bi bi-building"></i>
            <input type="number" id="etage" name="etage" placeholder="Ex: 1" required>
          </div>
        </div>
       <div class="mb-3">
  <label for="IDtypedechambre" class="form-label">Type de chambre</label>
  <div class="input-icon">
    <i class="bi bi-door-open"></i>
    <select id="IDtypedechambre" name="IDtypedechambre" required>
      <option value="" disabled selected>Choisir une chambre</option>
      <?php
      // Connexion
      $conn = new mysqli("localhost", "root", "", "hotel");
      if ($conn->connect_error) {
          die("Erreur de connexion : " . $conn->connect_error);
      }
      // Requête
      $sql = "SELECT IDtypedechambre, grade, prix FROM typedechambre";
      $result = $conn->query($sql);

      // Affichage des options
      while ($row = $result->fetch_assoc()) {
          echo '<option value="' . $row['IDtypedechambre'] . '" data-prix="' . $row['prix'] . '">'
              . htmlspecialchars($row['grade']) . ' - ' . htmlspecialchars($row['prix']) . ' €</option>';
      }
      $conn->close();
      ?>
    </select>
  </div>
</div>









        


        <button type="submit" class="btn">
          <i class="bi bi-plus-circle"></i> Ajouter la Chambre
        </button>
      </form>
      
      <a href="../accueil.php" class="btn-return">
        <i class="bi bi-arrow-left-circle"></i> retouer à l'accueil 💻
      </a>
    </div>
  </div>
  
  <div class="notification" id="notification">
    <i class="bi bi-check-circle-fill"></i>
    <span>Chambre ajoutée avec succès!</span>
  </div>

  <script>
    // Affichage du prix selon le type de chambre sélectionné
    document.getElementById("IDtypedechambre").addEventListener("change", function() {
      const selectedOption = this.options[this.selectedIndex];
      const price = selectedOption.getAttribute('data-prix');
      
      if (price) {
        document.getElementById("priceInfo").innerText = "Prix : " + price + "€ par nuit";
      } else {
        document.getElementById("priceInfo").innerText = "Sélectionnez un type pour voir le prix";
      }
    });

    // Afficher la notification si le formulaire est soumis avec succès
    <?php if(isset($_GET['message']) && $_GET['message'] == 'yes'): ?>
      document.addEventListener('DOMContentLoaded', function() {
        const notification = document.getElementById('notification');
        notification.classList.add('show');
        
        setTimeout(() => {
          notification.classList.remove('show');
        }, 3000);
      });
    <?php endif; ?>

    // Validation du formulaire avant soumission
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
      const numerochambre = document.getElementById('numerochambre').value;
      const etage = document.getElementById('etage').value;
      const type = document.getElementById('IDtypedechambre').value;
      
      if (!numerochambre || !etage || !type) {
        e.preventDefault();
        alert('Veuillez remplir tous les champs obligatoires.');
        return false;
      }
      
      return true;
    });
  </script>
</body>
</html>