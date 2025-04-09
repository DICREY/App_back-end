<?php
// 1. HEADERS CORS - DEBEN SER LAS PRIMERAS LÍNEAS
header("Access-Control-Allow-Origin: http://localhost:8081");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

// 2. MANEJO DE PREFLIGHT OPTIONS
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

// 3. CONEXIÓN A DB
include './database.php';

// 4. LEER INPUT
$json = file_get_contents('php://input');
$data = json_decode($json, true);

// 5. VALIDACIONES
if ($data === null) {
    http_response_code(400);
    die(json_encode(["error" => "Datos JSON inválidos"]));
}

if (empty($data['email']) || empty($data['password'])) {
    http_response_code(400);
    die(json_encode(["error" => "Email y contraseña son obligatorios"]));
}

// 6. PROCESAMIENTO
try {
    $email = $data['email'];
    $password = password_hash($data['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (ema_usu, pas_usu) VALUES (?, ?)";
    $stmt = $connection->prepare($sql);
    
    if (!$stmt) {
        throw new Exception("Error en preparación: " . $connection->error);
    }

    $stmt->bind_param("ss", $email, $password);
    
    if ($stmt->execute()) {
        http_response_code(201);
        echo json_encode([
            "success" => true,
            "id" => $stmt->insert_id
        ]);
    } else {
        throw new Exception("Error al insertar: " . $stmt->error);
    }

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        "error" => "Error interno",
        "message" => $e->getMessage()
    ]);
} finally {
    if (isset($stmt)) $stmt->close();
    $connection->close();
}
?>