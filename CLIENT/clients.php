<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'hotel';

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Erreur connexion : " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nomclient'];
    $email = $_POST['emailclient'];
    $numero = $_POST['numeroclient'];

    $sql = "INSERT INTO clients (nomclient, emailclient, numeroclient) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Erreur prepare() : " . $conn->error);
    }

    $stmt->bind_param("sss", $nom, $email, $numero);
    if ($stmt->execute()) {
        echo "Client ajouté avec succès.";
    } else {
        echo "Erreur : " . $stmt->error;
    }
}
?>



















  <!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ajouter un Client - Hôtel de Luxe</title>
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
      overflow-x: hidden;
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
      backdrop-filter: blur(1.5px);
      z-index: -1;
    }

    .container {
      max-width: 500px;
      width: 100%;
    }

    .card {
     background:rgba(0, 0, 0, 0.39);
      backdrop-filter: blur(7px) saturate(200%);
      -webkit-backdrop-filter: blur(16px) saturate(180%);
      border-radius: var(--border-radius);
      border: 1px solid var(--glass-border);
      box-shadow: 0 12px 30px var(--glass-shadow);
      padding: 30px;
      width: 100%;
      overflow: hidden;
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
      padding : 43%;
      position: center;
      font-size: 2.8rem;
      color: var(--primary-light);
      margin-bottom: 15px;
      text-align: center;
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

    .input-icon input {
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
    }

    .input-icon input::placeholder {
      color: rgba(255, 255, 255, 0.6);
    }

    .input-icon input:focus {
      border-color: var(--primary-light);
      box-shadow: 0 0 0 3px rgba(149, 213, 178, 0.3);
      outline: none;
      background-color: rgba(255, 255, 255, 0.18);
    }

    .input-icon input:focus + i {
      color: #fff;
      transform: translateY(-50%) scale(1.1);
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
    }

    .btn-return:hover {
      background: rgba(255, 255, 255, 0.15);
      border-color: rgba(255, 255, 255, 0.3);
      transform: translateY(-2px);
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
        <i class="bi bi-person-plus header-icon"></i>
        <h2>Ajouter un Client</h2>
        <p class="text-muted">Renseignez les informations du nouveau client pour l'enregistrer dans notre système</p>
      </div> 

      <form method="POST" action="">
        <div class="mb-3">
          <label for="nomclient" class="form-label">Nom du Client</label>
          <div class="input-icon">
            <i class="bi bi-person"></i>
            <input type="text" id="nomclient" name="nomclient" placeholder="Entrez le nom complet" required>
          </div>
        </div>
        
        <div class="mb-3">
          <label for="emailclient" class="form-label">Adresse Email</label>
          <div class="input-icon">
            <i class="bi bi-envelope"></i>
            <input type="email" id="emailclient" name="emailclient" placeholder="exemple@email.com" required>
          </div>
        </div>
        
        <div class="mb-3">
          <label for="numeroclient" class="form-label">Numéro de Téléphone</label>
          <div class="input-icon">
            <i class="bi bi-telephone"></i>
            <input type="tel" id="numeroclient" name="numeroclient" placeholder+="+33 1 23 45 67 89" required>
          </div>
        </div> 

        <button type="submit" class="btn">
          
          <i class="bi bi-plus-circle"></i> Ajouter le Client
        </button>
      </form>

      <a href="../accueil.php" class="btn-return">
        <i class="bi bi-arrow-left-circle"></i> Retour à l'accueil
      </a>
    </div>
  </div>

  <div class="notification" id="notification">
    <i class="bi bi-check-circle-fill"></i>
    <span>Client ajouté avec succès!</span>
  </div>

  <script>
    // Simulation d'envoi de formulaire
    const form = document.querySelector('form');
    const notification = document.getElementById('notification');
    
    form.addEventListener('submit', function(e) {
      e.preventDefault();
      
      // Afficher la notification
      notification.classList.add('show');
      
      // Cacher après 3 secondes
      setTimeout(() => {
        notification.classList.remove('show');
      }, 3000);
    });
  </script>
</body>
</html>
