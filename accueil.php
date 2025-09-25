<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Accueil - Hôtel Manager</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=SF+Pro+Display:wght@300;400;500;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet"> 
  <style>
    :root {
      --glass-bg: rgba(255, 255, 255, 0.08);
      --glass-border: rgba(255, 255, 255, 0.15);
      --glass-shadow: rgba(0, 0, 0, 0.1);
      --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      --secondary-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
      --accent-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    }

    * {
      box-sizing: border-box;
    }

    body {
      font-family: 'SF Pro Display', -apple-system, BlinkMacSystemFont, 'Inter', sans-serif;
      background-image: url('IMAGE/im3.jpg');
      background-size: cover; 
      background-position: center;
      backdrop-filter: blur(5px);
      background-attachment: fixed;  
      min-height: 100vh;
      margin: 0;
      overflow-x: hidden;
    }

    /* Glass Morphism Base */
    .glass {
      background: var(--glass-bg);
      backdrop-filter: blur(20px);
      -webkit-backdrop-filter: blur(20px);
      border: 1px solid var(--glass-border);
      border-radius: 20px;
      box-shadow: 0 8px 32px var(--glass-shadow);
    }

    .glass-card {
      background: rgba(255, 255, 255, 0.12);
      backdrop-filter: blur(15px);
      -webkit-backdrop-filter: blur(15px);
      border: 1px solid rgba(255, 255, 255, 0.2);
      border-radius: 16px;
      box-shadow: 0 4px 24px rgba(0, 0, 0, 0.15);
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .glass-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 40px rgba(0, 0, 0, 0.25);
      background: rgba(255, 255, 255, 0.15);
    }

    /* Navbar Glass */
    .navbar {
      background: rgba(255, 255, 255, 0.06) !important;
      backdrop-filter: blur(25px);
      -webkit-backdrop-filter: blur(25px);
      border-bottom: 1px solid rgba(255, 255, 255, 0.1);
      padding: 1rem 0;
    }

    .navbar-brand {
      color: white !important;
      font-weight: 600;
      font-size: 1.4rem;
    }

    .nav-link {
      color: rgba(255, 255, 255, 0.9) !important;
      font-weight: 500;
      transition: all 0.3s ease;
    }

    .nav-link:hover {
      color: white !important;
      transform: translateY(-1px);
    }

    .btn-outline-light {
      border: 1px solid rgba(255, 255, 255, 0.3);
      background: rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(10px);
      border-radius: 12px;
      transition: all 0.3s ease;
    }

    .btn-outline-light:hover {
      background: rgba(255, 255, 255, 0.2);
      border-color: rgba(255, 255, 255, 0.5);
      transform: translateY(-2px);
    }

    /* Sidebar Glass */
    .sidebar {
      position: fixed;
      top: 0;
      left: -320px;
      width: 320px;
      height: 100vh;
      background: rgba(0, 0, 0, 0.39);
      backdrop-filter: blur(40px);
      -webkit-backdrop-filter: blur(40px);
      border-right: 2px solid rgba(255, 255, 255, 0.26);
      box-shadow: 4px 0 40px rgba(0, 0, 0, 0.15);
      transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
      z-index: 1040;
      color: white;
      overflow-y: auto;
      overflow-x: hidden;
    }

    .sidebar::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 100%;
      background: linear-gradient(180deg,   
        rgba(255, 255, 255, 0.02) 0%, 
        rgba(255, 255, 255, 0.08) 30%,         
        rgba(255, 255, 255, 0.04) 70%, 
        rgba(255, 255, 255, 0.01) 100%);          
      pointer-events: none;
      z-index: -1;
    }

    .sidebar.show {
      left: 0;
      box-shadow: 8px 0 60px rgba(0, 0, 0, 0.25);
    }

    .sidebar h5 {
      color: rgba(255, 255, 255, 0.95);
      font-weight: 700;
      font-size: 1.3rem;
      margin-bottom: 2rem;
      text-align: center;
      padding: 1rem 0;
      border-bottom: 1px solid rgba(255, 255, 255, 0.1);
      background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.05), transparent);
    }

    .sidebar h6 {
      color: rgba(255, 255, 255, 0.85);
      font-weight: 600;
      font-size: 0.9rem;
      text-transform: uppercase; 
      letter-spacing: 1px;
      margin: 2rem 0 1rem 0;
      text-align: center;
      position: relative;
    }

    .sidebar h6::before,
    .sidebar h6::after {
      content: '';
      position: absolute;
      top: 50%;
      width: 30px;
      height: 1px;
      background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
    }

    .sidebar h6::before {
      left: 20px;
    }

    .sidebar h6::after {
      right: 20px;
    }

    .sidebar .nav-link {
      color: rgba(255, 255, 255, 0.85) !important;
      padding: 14px 20px;
      border-radius: 16px;
      margin: 6px 12px;
      transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
      font-weight: 500;
      font-size: 0.95rem;
      position: relative;
      overflow: hidden;
      border: 1px solid transparent;
    }

    .sidebar .nav-link::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
      transition: left 0.6s ease;
      z-index: 0;
    }

    .sidebar .nav-link:hover::before {
      left: 100%;
    }

    .sidebar .nav-link:hover {
      background: rgba(255, 255, 255, 0.15) !important;
      color: white !important;
      transform: translateX(8px) scale(1.02);
      border-color: rgba(255, 255, 255, 0.2);
      box-shadow: 0 4px 20px rgba(255, 255, 255, 0.1);
    }

    .sidebar .nav-link i {
      font-size: 1.1rem;
      margin-right: 12px;
      transition: all 0.3s ease;
      opacity: 0.9;
    }

    .sidebar .nav-link:hover i {
      opacity: 1;
      transform: scale(1.1);
    }

    /* Active state for sidebar links */
    .sidebar .nav-link.active {
      background: linear-gradient(135deg, rgba(79, 172, 254, 0.2) 0%, rgba(0, 242, 254, 0.15) 100%) !important;
      color: white !important;
      border-color: rgba(79, 172, 254, 0.3);
      box-shadow: 0 4px 20px rgba(79, 172, 254, 0.2);
    }

    /* Scrollbar styling for sidebar */
    .sidebar::-webkit-scrollbar {
      width: 6px;
    }

    .sidebar::-webkit-scrollbar-track {
      background: rgba(255, 255, 255, 0.05);
      border-radius: 10px;
    }

    .sidebar::-webkit-scrollbar-thumb {
      background: rgba(255, 255, 255, 0.2);
      border-radius: 10px;
      transition: all 0.3s ease;
    }

    .sidebar::-webkit-scrollbar-thumb:hover {
      background: rgba(255, 255, 255, 0.3);
    }

    /* Sidebar overlay for mobile */
    .sidebar-overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.5);
      backdrop-filter: blur(5px);
      -webkit-backdrop-filter: blur(5px);
      z-index: 1035;
      opacity: 0;
      visibility: hidden;
      transition: all 0.3s ease;
    }

    .sidebar-overlay.show {
      opacity: 1;
      visibility: visible;
    }

    .sidebar-toggle {
      top: 85px !important;
      left: 20px !important;
      z-index: 1050;
      background: linear-gradient(135deg, rgba(255, 255, 255, 0.15) 0%, rgba(255, 255, 255, 0.08) 100%) !important;
      border: 1px solid rgba(255, 255, 255, 0.25) !important;
      color: white !important;
      backdrop-filter: blur(15px);
      -webkit-backdrop-filter: blur(15px);
      border-radius: 14px;
      width: 50px;
      height: 50px;
      transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
      position: fixed;
      overflow: hidden;
    }

    .sidebar-toggle::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
      transition: left 0.6s ease;
    }

    .sidebar-toggle:hover::before {
      left: 100%;
    }

    .sidebar-toggle:hover {
      background: linear-gradient(135deg, rgba(255, 255, 255, 0.25) 0%, rgba(255, 255, 255, 0.15) 100%) !important;
      transform: scale(1.08);
      box-shadow: 0 6px 30px rgba(0, 0, 0, 0.25);
      border-color: rgba(255, 255, 255, 0.35) !important;
    }

    .sidebar-toggle:active {
      transform: scale(0.95);
    }

    .sidebar-toggle i {
      font-size: 1.3rem;
      transition: all 0.3s ease;
    }

    .sidebar.show + .main-content .sidebar-toggle i {
      transform: rotate(90deg);
    }

    /* Hero Section */
    .hero {
      min-height: 70vh;
      display: flex;
      align-items: center;
      justify-content: center;
      text-align: center;
      position: relative;
      overflow: hidden;
    }

    .hero::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: linear-gradient(45deg, rgba(255, 255, 255, 0.03) 0%, rgba(255, 255, 255, 0.08) 100%);
      z-index: -1;
    }

    .hero-content {
      color: white;
      max-width: 800px;
      padding: 2rem;
    }

    .hero h1 {
      font-size: clamp(2.5rem, 5vw, 4rem);
      font-weight: 700;
      margin-bottom: 1.5rem;
      background: linear-gradient(135deg, #ffffff 0%, rgba(255, 255, 255, 0.8) 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }

    .hero p {
      font-size: 1.3rem;
      font-weight: 400;
      opacity: 0.9;
      margin-bottom: 2rem;
    }

    .btn-primary {
      background: var(--primary-gradient);
      border: none;
      border-radius: 16px;
      padding: 14px 32px;
      font-weight: 600;
      font-size: 1.1rem;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      box-shadow: 0 4px 20px rgba(102, 126, 234, 0.4);
    }

    .btn-primary:hover {
      transform: translateY(-3px);
      box-shadow: 0 8px 30px rgba(102, 126, 234, 0.6);
      background: linear-gradient(135deg, #7b92ff 0%, #8a5eb8 100%);
    }

    /* Stats Cards */
    .stats-card {
      background: rgba(255, 255, 255, 0.12) !important;
      backdrop-filter: blur(15px) !important;
      -webkit-backdrop-filter: blur(15px) !important;
      border: 1px solid rgba(255, 255, 255, 0.2) !important;
      border-radius: 20px !important;
      color: white;
      transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
      overflow: hidden;
      position: relative;
    }

    .stats-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
      transition: left 0.6s;
    }

    .stats-card:hover::before {
      left: 100%;
    }

    .stats-card:hover {
      transform: translateY(-8px);
      background: rgba(255, 255, 255, 0.18) !important;
      box-shadow: 0 12px 40px rgba(0, 0, 0, 0.3);
    }

    .stats-card .icon {
      font-size: 2.5rem;
      margin-bottom: 1rem;
      color: #4facfe;
    }

    .stats-card h2 {
      font-size: 2.2rem;
      font-weight: 700;
      margin: 0.5rem 0;
    }

    .stats-card h5 {
      font-weight: 500;
      opacity: 0.9;
      margin-bottom: 0.5rem;
    }

    /* Feature Cards */
    .card-custom {
      background: rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(15px);
      -webkit-backdrop-filter: blur(15px);
      border: 1px solid rgba(255, 255, 255, 0.15);
      border-radius: 20px;
      color: white;
      transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
      overflow: hidden;
      position: relative;
    }

    .card-custom::after {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 2px;
      background: var(--accent-gradient);
      transform: scaleX(0);
      transform-origin: left;
      transition: transform 0.4s ease;
    }

    .card-custom:hover::after {
      transform: scaleX(1);
    }

    .card-custom:hover {
      transform: translateY(-5px) scale(1.02);
      background: rgba(255, 255, 255, 0.15);
      box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
    }

    .card-custom .icon {
      font-size: 3rem;
      margin-bottom: 1.5rem;
      background: var(--accent-gradient);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }

    /* Testimonials */
    .testimonial-card {
      background: rgba(255, 255, 255, 0.08) !important;
      backdrop-filter: blur(15px) !important;
      -webkit-backdrop-filter: blur(15px) !important;
      border: 1px solid rgba(255, 255, 255, 0.15) !important;
      border-radius: 20px !important;
      color: white;
      transition: all 0.3s ease;
    }

    .testimonial-card:hover {
      transform: translateY(-5px);
      background: rgba(255, 255, 255, 0.12) !important;
    }

    /* Footer Glass */
    footer {
      background: rgba(255, 255, 255, 0.05);
      backdrop-filter: blur(20px);
      -webkit-backdrop-filter: blur(20px);
      border-top: 1px solid rgba(255, 255, 255, 0.1);
      color: white;
      padding: 3rem 0 1rem;
      margin-top: 4rem;
    }

    .social-icon {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 40px;
      height: 40px;
      background: rgba(255, 255, 255, 0.1);
      border: 1px solid rgba(255, 255, 255, 0.2);
      border-radius: 50%;
      color: white;
      text-decoration: none;
      margin-right: 10px;
      transition: all 0.3s ease;
      backdrop-filter: blur(10px);
    }

    .social-icon:hover {
      background: rgba(255, 255, 255, 0.2);
      transform: translateY(-2px) scale(1.1);
      color: white;
    }

    /* Animations */
    .animate-fadeIn {
      opacity: 0;
      transform: translateY(30px);
      animation: fadeInUp 0.8s ease forwards;
    }

    .delay-1 { animation-delay: 0.2s; }
    .delay-2 { animation-delay: 0.4s; }
    .delay-3 { animation-delay: 0.6s; }

    @keyframes fadeInUp {
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    /* Container adjustments */
    .container {
      position: relative;
      z-index: 1;
    }

    .main-content {
      padding-top: 80px;
    }

    /* Text colors */
    h1, h2, h3, h4, h5, h6 {
      color: white;
    }

    p, small {
      color: rgba(255, 255, 255, 0.85);
    }

    .text-muted {
      color: rgba(255, 255, 255, 0.7) !important;
    }

    .text-success {
      color: #4ade80 !important;
    }

    /* Mobile Responsiveness */
    @media (max-width: 768px) {
      .hero h1 {
        font-size: 2.5rem;
      }
      
      .hero p {
        font-size: 1.1rem;
      }
      
      .stats-card {
        margin-bottom: 1rem;
      }
      
      .sidebar {
        width: 100%;
        left: -100%;
      }
      
      .sidebar-toggle {
        top: 20px !important;
        left: 15px !important;
      }
    }
  </style>
</head>

<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg fixed-top">
    <div class="container-fluid">
      <a class="navbar-brand" href="#"><i class="bi bi-building"></i> Hôtel Manager</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" style="border: none; background: rgba(255,255,255,0.1);">
        <span class="navbar-toggler-icon" style="filter: invert(1);"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto me-3">
          <li class="nav-item"><a class="nav-link" href="profil.php"><i class="bi bi-person-circle"></i> Mon Profil</a></li>
          <li class="nav-item"><a class="nav-link" href="settings.php"><i class="bi bi-gear"></i> Paramètres</a></li>
        </ul>
        <a href="logout.php" class="btn btn-outline-light"><i class="bi bi-box-arrow-right"></i> Se déconnecter</a>
      </div>
    </div>
  </nav>

  <!-- Sidebar Toggle -->
  <button class="btn sidebar-toggle" id="sidebarToggle"><i class="bi bi-list"></i></button>

  <!-- Sidebar Overlay for mobile -->
  <div class="sidebar-overlay" id="sidebarOverlay"></div>

  <div class="d-flex">
    <!-- Sidebar -->
    <div class="sidebar p-4" id="sidebar">
      <h5 class="text-center mb-4"><i class="bi bi-list"></i> Menu Principal</h5>
      <ul class="nav flex-column mb-4">
        <li class="nav-item">
          <a class="nav-link" href="Types_de_chambres.php">
            <i class="bi bi-door-closed me-2"></i> Types de chambres
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../hotel.php/RESERVATION/reservations.php">
            <i class="bi bi-calendar-check me-2"></i> Réservations
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../hotel.php/CLIENT/clients.php">
            <i class="bi bi-people me-2"></i> Clients
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="statistiques.php">
            <i class="bi bi-bar-chart me-2"></i> Statistiques
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../hotel.php/chambre/chambres.php">
            <i class="bi bi-house-door me-2"></i> Chambres
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="utilisateurs.php">
            <i class="bi bi-person-circle me-2"></i> Utilisateurs
          </a>
        </li>
      </ul>
      <hr>
      <h6 class="text-center mb-3">Listes détaillées</h6>
      <ul class="nav flex-column">
        <li class="nav-item">
          <a class="nav-link" href="../hotel.php/CLIENT/listeclient.php">
            <i class="bi bi-list-ul me-2"></i> Liste des clients
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="listerese.php">
            <i class="bi bi-list-ul me-2"></i> Liste des réservations
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../hotel.php/RESERVATION/liste_chambres.php">
            <i class="bi bi-list-ul me-2"></i> Liste des chambres
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="liste_utilisateurs.php">
            <i class="bi bi-list-ul me-2"></i> Liste des utilisateurs
          </a>
        </li>
      </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content flex-grow-1">
      <!-- Hero Section -->
      <section class="hero">
        <div class="hero-content animate-fadeIn">
          <h1 class="display-4">Bienvenue dans votre espace hôtel</h1>
          <p class="lead delay-1">Gérez vos clients, chambres et réservations en toute simplicité</p>
          <a href="reservations.php" class="btn btn-primary mt-3 delay-2"><i class="bi bi-calendar-check me-2"></i>Voir les réservations</a>
        </div>
      </section>

      <!-- Statistiques Rapides -->
      <div class="container my-5">
        <h2 class="text-center mb-4 animate-fadeIn">Aperçu en temps réel</h2>
        <div class="row g-4">
          <div class="col-md-3 col-6">
            <div class="card stats-card p-3 animate-fadeIn delay-1 text-center">
              <i class="bi bi-door-closed icon"></i>
              <h5 class="card-title">Chambres occupées</h5>
              <h2>12/24</h2>
              <p><small class="text-success"><i class="bi bi-arrow-up"></i> 80% occupation</small></p>
            </div>
          </div>
          <div class="col-md-3 col-6">
            <div class="card stats-card p-3 animate-fadeIn delay-2 text-center">
              <i class="bi bi-calendar-event icon"></i>
              <h5 class="card-title">Arrivées aujourd'hui</h5>
              <h2>5</h2>
              <p><small>3 départs</small></p>
            </div>
          </div>
          <div class="col-md-3 col-6">
            <div class="card stats-card p-3 animate-fadeIn delay-3 text-center">
              <i class="bi bi-graph-up icon"></i>
              <h5 class="card-title">Taux d'occupation</h5>
              <h2>80%</h2>
              <p><small class="text-success"><i class="bi bi-arrow-up"></i> 5% vs hier</small></p>
            </div>
          </div>
          <div class="col-md-3 col-6">
            <div class="card stats-card p-3 animate-fadeIn text-center">
              <i class="bi bi-currency-euro icon"></i>
              <h5 class="card-title">Revenu du mois</h5>
              <h2>12 450€</h2>
              <p><small class="text-success"><i class="bi bi-arrow-up"></i> 15% vs mois dernier</small></p>
            </div>
          </div>
        </div>
      </div>

      <!-- Présentation Hôtel -->
      <div class="container my-5">
        <h2 class="text-center mb-4 animate-fadeIn">Notre Hôtel en Quelques Mots</h2>
        <p class="text-center text-muted mb-5 animate-fadeIn delay-1">Profitez d'un cadre luxueux, d'un service irréprochable et d'installations modernes pour rendre votre séjour inoubliable.</p>
        <div class="row g-4">
          <div class="col-md-4">
            <div class="card card-custom text-center p-4 animate-fadeIn delay-2">
              <i class="bi bi-door-closed icon"></i>
              <h5>Chambres Confortables</h5>
              <p>Des chambres spacieuses et modernes adaptées à tous les besoins.</p>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card card-custom text-center p-4 animate-fadeIn delay-3">
              <i class="bi bi-wifi icon"></i>
              <h5>Services Modernes</h5>
              <p>Connexion Wi‑Fi haut débit, service en chambre et plus encore.</p>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card card-custom text-center p-4 animate-fadeIn delay-1">
              <i class="bi bi-cup-hot icon"></i>
              <h5>Restaurant & Bar</h5>
              <p>Une cuisine raffinée et un bar convivial pour vos moments de détente.</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Témoignages -->
      <div class="py-5" style="background: linear-gradient(135deg, rgba(255, 255, 255, 0.05) 0%, rgba(255, 255, 255, 0.1) 100%) !important;">
        <div class="container">
          <h2 class="text-center mb-5 animate-fadeIn">Ce que disent nos clients</h2>
          <div class="row g-4">
            <div class="col-md-4">
              <div class="card testimonial-card p-4 animate-fadeIn delay-1 text-center">
                <div class="mb-3">
                  <i class="bi bi-star-fill text-warning"></i>
                  <i class="bi bi-star-fill text-warning"></i>
                  <i class="bi bi-star-fill text-warning"></i>
                  <i class="bi bi-star-fill text-warning"></i>
                  <i class="bi bi-star-fill text-warning"></i>
                </div>
                <p class="fst-italic">"Un service exceptionnel et des chambres très confortables. Je recommande vivement!"</p>
                <p class="fw-bold">Marie L.</p>
                <small>Client régulier</small>
              </div>
            </div>
            <div class="col-md-4">
              <div class="card testimonial-card p-4 animate-fadeIn delay-2 text-center">
                <div class="mb-3">
                  <i class="bi bi-star-fill text-warning"></i>
                  <i class="bi bi-star-fill text-warning"></i>
                  <i class="bi bi-star-fill text-warning"></i>
                  <i class="bi bi-star-fill text-warning"></i>
                  <i class="bi bi-star-half text-warning"></i>
                </div>
                <p class="fst-italic">"Le personnel est très attentionné et l'emplacement est parfait. J'y reviendrai."</p>
                <p class="fw-bold">Thomas D.</p>
                <small>Voyage d'affaires</small>
              </div>
            </div>
            <div class="col-md-4">
              <div class="card testimonial-card p-4 animate-fadeIn delay-3 text-center">
                <div class="mb-3">
                  <i class="bi bi-star-fill text-warning"></i>
                  <i class="bi bi-star-fill text-warning"></i>
                  <i class="bi bi-star-fill text-warning"></i>
                  <i class="bi bi-star-fill text-warning"></i>
                  <i class="bi bi-star-fill text-warning"></i>
                </div>
                <p class="fst-italic">"Le restaurant propose une cuisine délicieuse. Un séjour parfait du début à la fin."</p>
                <p class="fw-bold">Sophie M.</p>
                <small>Séjour romantique</small>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Footer -->
      <footer>
        <div class="container">
          <div class="row">
            <!-- À propos -->
            <div class="col-md-4 mb-4">
              <h5>Hôtel Manager</h5>
              <p>Application de gestion hôtelière</p>
              <p><i class="bi bi-award me-2"></i> Solution développée par Daniel</p>
            </div>

            <!-- Contact -->
            <div class="col-md-4 mb-4">
              <h5>Contact</h5>
              <p><i class="bi bi-telephone me-2"></i> +225 07 07 07 07</p>
              <p><i class="bi bi-envelope me-2"></i> daniel.dev@hotelmanager.com</p>
              <p><i class="bi bi-geo-alt me-2"></i> Abidjan, Côte d'Ivoire</p>
            </div>

            <!-- Réseaux sociaux -->
            <div class="col-md-4">
              <h5>Suivez-nous</h5>
              <div class="d-flex mb-3">
                <a href="#" class="social-icon"><i class="bi bi-facebook"></i></a>
                <a href="#" class="social-icon"><i class="bi bi-twitter"></i></a>
                <a href="#" class="social-icon"><i class="bi bi-instagram"></i></a>
                <a href="#" class="social-icon"><i class="bi bi-linkedin"></i></a>
                <a href="#" class="social-icon"><i class="bi bi-youtube"></i></a>
              </div>
              <img src="https://via.placeholder.com/120x40/4A5568/FFFFFF?text=Paiement+Securise" 
                   alt="Paiement sécurisé" 
                   class="img-fluid rounded">
            </div>
          </div>

          <hr class="my-4">
          <p class="text-center mb-0">&copy; 2025 Hôtel Manager — Développé avec ❤️ par Daniel</p>
        </div>
      </footer>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Sidebar Toggle
    document.getElementById('sidebarToggle').addEventListener('click', function() {
      const sidebar = document.getElementById('sidebar');
      const overlay = document.getElementById('sidebarOverlay');
      
      sidebar.classList.toggle('show');
      overlay.classList.toggle('show');
      
      // Add body scroll lock when sidebar is open on mobile
      if (window.innerWidth <= 768) {
        document.body.style.overflow = sidebar.classList.contains('show') ? 'hidden' : '';
      }
    });

    // Close sidebar when clicking outside or on overlay
    document.getElementById('sidebarOverlay').addEventListener('click', function() {
      closeSidebar();
    });

    function closeSidebar() {
      const sidebar = document.getElementById('sidebar');
      const overlay = document.getElementById('sidebarOverlay');
      
      sidebar.classList.remove('show');
      overlay.classList.remove('show');
      document.body.style.overflow = '';
    }

    // Close sidebar with escape key
    document.addEventListener('keydown', function(event) {
      if (event.key === 'Escape') {
        closeSidebar();
      }
    });

    // Add active state to current page link
    function setActiveLink() {
      const currentPage = window.location.pathname.split('/').pop();
      const sidebarLinks = document.querySelectorAll('.sidebar .nav-link');
      
      sidebarLinks.forEach(link => {
        const href = link.getAttribute('href');
        if (href === currentPage || (currentPage === '' && href === 'index.php')) {
          link.classList.add('active');
        }
      });
    }

    // Sidebar link hover effects
    function addSidebarEffects() {
      const sidebarLinks = document.querySelectorAll('.sidebar .nav-link');
      
      sidebarLinks.forEach(link => {
        link.addEventListener('click', function(e) {
          // Add ripple effect
          const ripple = document.createElement('span');
          const rect = this.getBoundingClientRect();
          const size = Math.max(rect.width, rect.height);
          const x = e.clientX - rect.left - size / 2;
          const y = e.clientY - rect.top - size / 2;
          
          ripple.style.cssText = `
            position: absolute;
            width: ${size}px;
            height: ${size}px;
            left: ${x}px;
            top: ${y}px;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            transform: scale(0);
            animation: ripple 0.6s ease-out;
            pointer-events: none;
            z-index: 1;
          `;
          
          this.style.position = 'relative';
          this.appendChild(ripple);
          
          setTimeout(() => {
            ripple.remove();
          }, 600);
        });
      });
    }

    // Add CSS animation for ripple effect
    const style = document.createElement('style');
    style.textContent = `
      @keyframes ripple {
        to {
          transform: scale(2);
          opacity: 0;
        }
      }
    `;
    document.head.appendChild(style);

    // Animation on scroll
    const observerOptions = {
      threshold: 0.1,
      rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.style.animationPlayState = 'running';
        }
      });
    }, observerOptions);

    // Observe all animated elements
    document.querySelectorAll('.animate-fadeIn').forEach(el => {
      el.style.animationPlayState = 'paused';
      observer.observe(el);
    });

    // Parallax effect for hero section
    window.addEventListener('scroll', () => {
      const scrolled = window.pageYOffset;
      const parallax = document.querySelector('.hero');
      const speed = scrolled * 0.5;
      
      if (parallax) {
        parallax.style.transform = `translate3d(0, ${speed}px, 0)`;
      }
    });

    // Smooth scrolling for internal links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
      anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
          target.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
          });
        }
      });
    });

    // Dynamic glass effect intensity based on scroll
    window.addEventListener('scroll', () => {
      const scrolled = window.pageYOffset;
      const navbar = document.querySelector('.navbar');
      const maxScroll = 100;
      const intensity = Math.min(scrolled / maxScroll, 1);
      
      if (navbar) {
        navbar.style.background = `rgba(255, 255, 255, ${0.06 + (intensity * 0.04)})`;
        navbar.style.backdropFilter = `blur(${25 + (intensity * 10)}px)`;
      }
    });

    // Loading animation for stats cards
    function animateCounter(element, target, duration = 2000) {
      let start = 0;
      const increment = target / (duration / 16);
      
      function updateCounter() {
        start += increment;
        if (start < target) {
          element.textContent = Math.floor(start);
          requestAnimationFrame(updateCounter);
        } else {
          element.textContent = target;
        }
      }
      updateCounter();
    }

    // Animate counters when stats cards come into view
    const statsObserver = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          const counterElements = entry.target.querySelectorAll('h2');
          counterElements.forEach(counter => {
            const text = counter.textContent;
            const numbers = text.match(/\d+/g);
            if (numbers) {
              const target = parseInt(numbers[0]);
              animateCounter(counter, target);
            }
          });
          statsObserver.unobserve(entry.target);
        }
      });
    });

    document.querySelectorAll('.stats-card').forEach(card => {
      statsObserver.observe(card);
    });

    // Responsive sidebar behavior
    function handleResize() {
      const sidebar = document.getElementById('sidebar');
      const overlay = document.getElementById('sidebarOverlay');
      const screenWidth = window.innerWidth;
      
      if (screenWidth > 768) {
        sidebar.classList.remove('show');
        overlay.classList.remove('show');
        document.body.style.overflow = '';
      }
    }

    window.addEventListener('resize', handleResize);

    // Initialize page
    document.addEventListener('DOMContentLoaded', function() {
      // Initialize sidebar effects
      setActiveLink();
      addSidebarEffects();
      
      // Preload images for better performance
      const images = ['https://via.placeholder.com/120x40/4A5568/FFFFFF?text=Paiement+Securise'];
      images.forEach(src => {
        const img = new Image();
        img.src = src;
      });
    });
  </script>
</body>
</html>