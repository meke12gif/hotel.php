
 <?php
include "../connexionbd.phpconnexionbd.php"; // connexion à la base

if (isset($_POST['IDclients'])) {
    $IDclients = $_POST['IDclients'];

   
    $req = $bdd->prepare("DELETE FROM clients WHERE IDclients = ?");
    $req->execute([$IDclients]);
} 
header("Location: listeclient.php"); // Remplace par le nom exact de ton fichier (peut-être index.php ou autre)
exit();
?>
,    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
