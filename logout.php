<?php
session_start();
session_unset();      // Supprime toutes les variables de session
session_destroy();    // Détruit la session

// Redirection vers la page de login ou d'accueil
header("Location: connexion.php"); // Ou "index.php"
exit();