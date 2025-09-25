<?php
include 'connexionbd.php';

$req = $bdd->prepare("SELECT * FROM clients_chambre");
$req->execute();
$clients_chambre  = $req->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">    
    


    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des réservations</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
        .action-buttons form {
            display: inline;
        }
        .edit-btn, .delete-btn {
            padding: 5px 10px;
            margin: 0 2px;
            border: none;
            cursor: pointer;
        }
        .edit-btn {
            background-color: #4CAF50; /* Green */
            color: white;
        }
        .delete-btn {
            background-color: #f44336; /* Red */
            color: white;
        }
        .back-link {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            color: #007BFF;
        }  
        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h1>Liste des réservations</h1>
    <table>
        <thead>
            <tr> 
                <th>ID Client</th>
                <th>ID Chambre</th>
                <th>Date de début</th>
                <th>Date de fin</th>
                <th>Actions</th>   
            </tr>
        </thead>
        <tbody>
            <?php foreach ($clients_chambre as $reservation): ?>
            <tr>
                <td><?= htmlspecialchars($reservation['IDclients']); ?></td>
                <td><?= htmlspecialchars($reservation['IDchambre']); ?></td>
                <td><?= htmlspecialchars($reservation['date_debut']); ?></td>
                <td><?= htmlspecialchars($reservation['date_fin']); ?></td>
                <td class="action-buttons">
                    <!-- Bouton Modifier -->
                    <form action="modifier_reservation.php" method="get">
                        <input type="hidden" name="IDclients" value="<?= $reservation['IDclients']; ?>">
                        <button type="submit" class="edit-btn">Modifier</button>
                    </form>

                    <!-- Bouton Supprimer -->
                    <form action="supprimer_reservation.php" method="post" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette réservation ?');">    
                        <input type="hidden" name="IDclients" value="<?= $reservation['IDclients']; ?>">
                        <button type="submit" class="delete-btn">Supprimer</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <a href="index.php" class="back-link">Retour au menu principal</a>
</body>
</html>
