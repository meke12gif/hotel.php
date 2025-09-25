<?php
if (!isset($_GET['idchambre'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Pas d’ID de chambre fourni']);
    exit;
}

$idchambre = intval($_GET['idchambre']);

$conn = new mysqli("localhost", "root", "", "hotel");
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(['error' => 'Erreur de connexion BDD']);
    exit;
}

$sql = "SELECT tc.grade FROM chambre c   JOIN typedchambre tc ON c.IDtypedchambre = tc.IDtypedchambre WHERE c.IDchambre = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $idchambre);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo json_encode(['grade' => $row['grade']]);
} else {
    echo json_encode(['grade' => 'Non défini']);
}

$stmt->close();
$conn->close();
?>""