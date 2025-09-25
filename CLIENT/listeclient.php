   <?php
// listeclient.php
include '../connexionbd.php';

$req = $bdd->prepare("SELECT * FROM clients");
$req->execute();
$clients = $req->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des clients</title>
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
    <h1>Liste des clients</h1>
    <table>
        <thead>
            <tr>
                <th>ID Client</th>
                <th>Nom</th>
                <th>Email</th> 
                <th>Numéro</th>   
                <th>Actions</th>
            </tr>     
        </thead>
        <tbody>
            <?php foreach ($clients as $client): ?> 
            <tr> 
                <td><?php echo htmlspecialchars($client['IDclients']); ?></td>
                <td><?php echo htmlspecialchars($client['nomclient']); ?></td>
                <td><?php echo htmlspecialchars($client['emailclient']); ?></td>
                <td><?php echo htmlspecialchars($client['numeroclient']); ?></td>
                <td class="action-buttons">

<form action="modifier_client.php" method="get" style="display: inline;">
    <input type="hidden" name="IDclients" value="<?php echo $client['IDclients']; ?>">
    <button type="submit" class="edit-btn">Modifier</button>
</form>

<form action="supprimer_client.php" method="post" style="display: inline;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce client ?');">
    <input type="hidden" name="IDclients" value="<?php echo $client['IDclients']; ?>">
    <button type="submit" class="delete-btn">Supprimer</button>
</form>

            <?php endforeach; ?>
        </tbody>
    </table>
    <a href="accueil.php" class="back-link">Retour au menu principal</a>