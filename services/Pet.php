<?php

    require_once __DIR__ . '/database.php';

    // mascotas.php - Operaciones CRUD para mascotas
    class Mascota {
        private $db;

        public function __construct() {
            $database = new Database();
            $this->db = $database->getConnection();
        }

        // Crear nueva mascota
        public function crearMascota($data) {
            $query = "INSERT INTO mascotas 
                    (nom_mas, esp_mas, col_mas, raz_mas, ali_mas, fec_nac_mas, 
                    pes_mas, gen_mas, id_pro_mas) 
                    VALUES 
                    (:nombre, :especie, :color, :raza, :alimento, :fecha_nac, 
                    :peso, :genero, :propietario)";
            
            $stmt = $this->db->prepare($query);
            
            $stmt->bindParam(":nombre", $data['nombre']);
            $stmt->bindParam(":especie", $data['especie']);
            $stmt->bindParam(":color", $data['color']);
            $stmt->bindParam(":raza", $data['raza']);
            $stmt->bindParam(":alimento", $data['alimento']);
            $stmt->bindParam(":fecha_nac", $data['fecha_nac']);
            $stmt->bindParam(":peso", $data['peso']);
            $stmt->bindParam(":genero", $data['genero']);
            $stmt->bindParam(":propietario", $data['propietario']);
            
            return $stmt->execute();
        }

        // Obtener mascota por ID
        public function obtenerMascota($id) {
            $query = "SELECT m.*, u.nom_usu, u.ape_usu 
                    FROM mascotas m 
                    JOIN usuarios u ON m.id_pro_mas = u.doc_usu
                    WHERE m.nom_mas = :id AND m.estado = 1";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(":id", $id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        // Obtener mascota por ID
        public function obtenerMascotas() {
            $query = "SELECT m.*, u.nom_usu, u.ape_usu 
                FROM mascotas m 
                JOIN usuarios u ON m.id_pro_mas = u.doc_usu
                WHERE m.estado = 1";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        // Obtener todas las mascotas de un propietario
        public function obtenerMascotasPorPropietario($propietario) {
            $query = "SELECT * FROM mascotas 
                    WHERE id_pro_mas = :propietario AND estado = 1";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(":propietario", $propietario);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        // Actualizar mascota
        public function actualizarMascota($id, $data) {
            $query = "UPDATE mascotas SET 
                    nom_mas = :nombre, 
                    esp_mas = :especie,
                    col_mas = :color,
                    raz_mas = :raza,
                    ali_mas = :alimento,
                    fec_nac_mas = :fecha_nac,
                    pes_mas = :peso,
                    gen_mas = :genero
                    WHERE id_mas = :id";
            
            $stmt = $this->db->prepare($query);
            
            $stmt->bindParam(":nombre", $data['nombre']);
            $stmt->bindParam(":especie", $data['especie']);
            $stmt->bindParam(":color", $data['color']);
            $stmt->bindParam(":raza", $data['raza']);
            $stmt->bindParam(":alimento", $data['alimento']);
            $stmt->bindParam(":fecha_nac", $data['fecha_nac']);
            $stmt->bindParam(":peso", $data['peso']);
            $stmt->bindParam(":genero", $data['genero']);
            $stmt->bindParam(":id", $id);
            
            return $stmt->execute();
        }

        // Desactivar mascota (borrado lógico)
        public function desactivarMascota($id) {
            $query = "UPDATE mascotas SET estado = 0 WHERE id_mas = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(":id", $id);
            return $stmt->execute();
        }
    }
?>