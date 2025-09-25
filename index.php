<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Page de connexion</title>
  <style>
    /* Fond particules simples */
    .particles {
      position: fixed;
      width: 100vw;
      height: 100vh;
      background: radial-gradient(circle, #6a11cb 2px, transparent 2px),
                  radial-gradient(circle, #2575fc 2px, transparent 2px);
      background-position: 0 0, 25px 25px;
      background-size: 50px 50px;
      animation: moveParticles 10s linear infinite;
      z-index: -1;
    }

    @keyframes moveParticles {
      from { background-position: 0 0, 25px 25px; }
      to { background-position: 50px 50px, 75px 75px; }
    }

    /* Conteneur centré */
    .container {
      height: 100vh;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      gap: 1.5rem;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      color: white;
      text-align: center;
      padding: 20px;
    }

    h1 {
      font-size : black ;  
      font-size: 2.5rem;
      text-shadow: 0 2px 5px rgba(0,0,0,0.4);
    }

    /* Bouton stylé */
    .btn-bienvenue {
      background-color: #4caf50;
      border: none;
      padding: 1rem 3rem;
      font-size: 1.3rem;
      color: white;
      border-radius: 40px;
      cursor: pointer;
      box-shadow: 0 5px 15px rgba(76, 175, 80, 0.6);
      transition: background-color 0.3s ease, transform 0.2s ease;
      user-select: none;
    }

    .btn-bienvenue:hover {
      background-color: #45a049;
      transform: scale(1.05);
    }

    .btn-bienvenue:active {
      transform: scale(0.95);
    }

    /* Loading dots */
    .loading-dots {
      display: flex;
      gap: 0.5rem;
      margin-top: 1rem;
      visibility: hidden; /* cachés par défaut */
    }

    .loading-dots span {
      width: 12px;
      height: 12px;
      background-color: white;
      border-radius: 50%;
      animation: loadingBounce 1.2s infinite ease-in-out;
      opacity: 0.7;
    }

    .loading-dots span:nth-child(1) {
      animation-delay: 0s;
    }
    .loading-dots span:nth-child(2) {
      animation-delay: 0.2s;
    }
    .loading-dots span:nth-child(3) {
      animation-delay: 0.4s;
    }

    @keyframes loadingBounce {
      0%, 80%, 100% {
        transform: scale(0);
        opacity: 0.7;
      }
      40% {
        transform: scale(1);
        opacity: 1;
      }
    }
  </style>
</head>
<body>

  <div class="particles"></div>

  <div class="container">
    <h1>Cliquez ici pour vous connecter</h1>

    <button class="btn-bienvenue" onclick="handleConnection()">
      Se Connecter
    </button>

    <div class="loading-dots" id="loadingDots">
      <span></span>
      <span></span>
      <span></span>
    </div>
  </div>

  <script>
    function handleConnection() {
      // Afficher les points de chargement
      const loading = document.getElementById('loadingDots');
      loading.style.visibility = 'visible';

      // Simuler un délai (ex: chargement de la page connexion.php)
      setTimeout(() => {
        window.location.href = 'connexion.php';
      }, 2000); // 2 secondes d'attente
    }
  </script>

</body>
</html>
