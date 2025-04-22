<?php

    header("Access-Control-Allow-Origin: http://localhost:8081");
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Authorization");
    header("Content-Type: application/json");

    // Habilitar logging
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    // Para peticiones OPTIONS (preflight)
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    header("HTTP/1.1 200 OK");
    exit();
    }

    // api/pets.php
    require_once('../services/Pet.php');

    try {
        $action = $_GET['action'] ?? '';
        $pet = new Mascota();

        switch ($action) {
            case 'create':
                $data = json_decode(file_get_contents('php://input'), true);
                $result = $pet->crearMascota($data);
                if ($result){
                    echo json_encode(['success' => $result]);
                } else echo http_response_code(500);
                break;
                
            case 'byOwner':
                $id = $_GET['id'] ?? 0;
                $result = $pet->obtenerMascotasPorPropietario($id);
                if ($result){
                    echo json_encode(['success' => $result]);
                } else echo http_response_code(500);
                break;
                
            case 'read':
                $id = $_GET['id'] ?? 0;
                $result = $pet->obtenerMascota($id);
                if ($result){
                    echo json_encode(['success' => $result]);
                } else echo http_response_code(500);
                break;

            case 'read':
                $result = $pet->obtenerMascotas();
                if ($result){
                    echo json_encode(['success' => $result]);
                } else echo http_response_code(500);
                break;
                
            case 'update':
                $id = $_GET['id'] ?? 0;
                $data = json_decode(file_get_contents('php://input'), true);
                $result = $pet->actualizarMascota($id, $data);
                if ($result){
                    echo json_encode(['success' => $result]);
                } else echo http_response_code(500);
                break;
                
            case 'delete':
                $id = $_GET['id'] ?? 0;
                $result = $pet->desactivarMascota($id);
                if ($result){
                    echo json_encode(['success' => $result]);
                } else echo http_response_code(500);
                break;
                
            default:
                http_response_code(404);
                echo json_encode(['error' => 'Acción no válida']);
        }
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode([
            'error' => 'Error en el servidor',
            'message' => $e->getMessage(),
            'trace' => $e->getTraceAsString() // Solo en desarrollo
        ]);
    }

?>