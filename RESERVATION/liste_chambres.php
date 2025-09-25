<?php
// Connexion à la base de données
$conn = new mysqli("localhost", "root", "", "hotel");
if ($conn->connect_error) {
    die("❌ Erreur de connexion : " . $conn->connect_error);
}

// Requête SQL avec jointures
$sql = "
    SELECT 
        cc.IDclients, cc.IDchambre, cc.datedebut,
        c.nomclient, c.emailclient,
        ch.numerochambre, ch.etage,
        t.grade, t.prix,
        u.nom AS utilisateur,
        cc.datefin
    FROM clients_chambre cc
    JOIN clients c ON cc.IDclients = c.IDclients
    JOIN chambre ch ON cc.IDchambre = ch.IDchambre
    JOIN typedechambre t ON ch.IDtypedechambre = t.IDtypedechambre
    JOIN utilisateur u ON cc.IDutilisateur = u.IDutilisateur
";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Réservations</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }

        h2 {
            color: #333;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #f4f4f4;
        }

        .action-buttons button {
            padding: 6px 12px;
            margin: 2px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .modifier {
            background-color: #007bff;
            color: white;
        }

        .supprimer {
            background-color: #dc3545;
            color: white;
        }

        .recherche-form {
            margin-bottom: 20px;
        }

        .recherche-form input[type="text"] {
            padding: 8px;
            width: 300px;
        }

        .recherche-form button {
            padding: 8px 16px;
        }
    </style>
</head>
<body>

<h2>📋 Liste des Réservations</h2>

<!-- 🔍 Formulaire de recherche (à améliorer si besoin) -->
<form method="GET" class="recherche-form">
    <input type="text" name="q" placeholder="Rechercher par nom client...">
    <button type="submit">🔍 Rechercher</button>
</form>

<table>
    <tr>
        <th>Nom Client</th>
        <th>Email</th>
        <th>Chambre</th>
        <th>Étage</th>
        <th>Grade</th>
        <th>Prix</th>
        <th>Utilisateur</th>
        <th>Date Début</th>
        <th>Date Fin</th>
        <th>Actions</th>
    </tr>

    <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['nomclient']) ?></td>
                <td><?= htmlspecialchars($row['emailclient']) ?></td>
                <td><?= htmlspecialchars($row['numerochambre']) ?></td>
                <td><?= htmlspecialchars($row['etage']) ?></td>
                <td><?= htmlspecialchars($row['grade']) ?></td>
                <td><?= htmlspecialchars($row['prix']) ?> $</td> 
                <td><?= htmlspecialchars($row['utilisateur']) ?></td>
                <td><?= htmlspecialchars($row['datedebut']) ?></td>
                <td><?= htmlspecialchars($row['datefin']) ?></td> 
                <td class="action-buttons">
    <a href="../hotel.php/RESERVATION/modifier.php?idclient=<?= htmlspecialchars($row['IDclients']) ?>&idchambre=<?= htmlspecialchars($row['IDchambre']) ?>&datedebut=<?= htmlspecialchars($row['datedebut']) ?>">
        <button class="modifier">Modifier</button>
    </a>
    <a href="../hotel.php/RESERVATION/supprimer.php?idclient=<?= htmlspecialchars($row['IDclients']) ?>&idchambre=<?= htmlspecialchars($row['IDchambre']) ?>&datedebut=<?= htmlspecialchars($row['datedebut']) ?>" 
       onclick="return confirm('❗ Voulez-vous vraiment supprimer cette réservation ?')">
        <button class="supprimer">Supprimer</button>
    </a>
</td>
            </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr><td colspan="10">Aucune réservation trouvée</td></tr>
    <?php endif; ?>
</table>

</body>
</html>
