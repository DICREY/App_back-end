<?php
    // Headers request 
    header("Content-Type: application/json");
    header("Access-Control-Allow-Origin: *");

    // Conexión a DB
    include './database.php';


try {
    // Consulta SQL con parámetros seguros
    $sql = "SELECT ema_usu,pas_usu FROM users";
    
    $stmt = $connection->prepare($sql);

    $stmt->execute();

    $result = $stmt->get_result();
    
    $users = [];
    while ($row = $result->fetch_assoc()) {
        // Ocultar información sensible
        unset($row['password_hash']); 
        $users[] = $row;
    }

    // Respuesta exitosa
    echo json_encode([
        "success" => true,
        "page" => $page,
        "limit" => $limit,
        "total" => count($users),
        "data" => $users
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["error" => "Error del servidor: " . $e->getMessage()]);
} finally {
    $stmt->close();
    $connection->close();
}
?>