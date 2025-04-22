<?php
    // Imports 
    require_once __DIR__ . '/database.php';

    // usuarios.php - Operaciones CRUD para usuarios
    class Usuario {
        private $db;

        public function __construct() {
            $database = new Database();
            $this->db = $database->getConnection();
        }

        // Crear un nuevo usuario
        public function crearUsuario($data) {
            $query = "INSERT INTO usuarios 
                    (nom_usu, ape_usu, fec_nac_usu, tip_doc_usu, doc_usu, dir_usu, 
                    cel_usu, cel2_usu, email_usu, cont_usu, gen_usu) 
                    VALUES 
                    (:nombre, :apellido, :fecha_nacimiento, :tipo_documento, :documento, :direccion, 
                    :celular, :celular2, :email, :contrasena, :genero)";
            
            $stmt = $this->db->prepare($query);
            
            // Hash de la contraseña
            $hashed_password = password_hash($data['contrasena'], PASSWORD_BCRYPT);
            
            $stmt->bindParam(":nombre", $data['nombre']);
            $stmt->bindParam(":apellido", $data['apellido']);
            $stmt->bindParam(":fecha_nacimiento", $data['fecha_nacimiento']);
            $stmt->bindParam(":tipo_documento", $data['tipo_documento']);
            $stmt->bindParam(":documento", $data['documento']);
            $stmt->bindParam(":direccion", $data['direccion']);
            $stmt->bindParam(":celular", $data['celular']);
            $stmt->bindParam(":celular2", $data['celular2']);
            $stmt->bindParam(":email", $data['email']);
            $stmt->bindParam(":contrasena", $hashed_password);
            $stmt->bindParam(":genero", $data['genero']);
            
            return $stmt->execute();
        }

        // Obtener usuario por ID
        public function obtenerUsuario($id) {
            $query = "SELECT * FROM usuarios WHERE id_usu = :id AND estado = 1";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(":id", $id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        // Obtener usuario por ID
        public function obtenerUsuarios() {
            $query = "SELECT * FROM usuarios WHERE estado = 1";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        // Actualizar usuario
        public function actualizarUsuario($id, $data) {
            $query = "UPDATE usuarios SET 
                    nom_usu = :nombre, 
                    ape_usu = :apellido,
                    fec_nac_usu = :fecha_nacimiento,
                    tip_doc_usu = :tipo_documento,
                    dir_usu = :direccion,
                    cel_usu = :celular,
                    cel2_usu = :celular2,
                    email_usu = :email,
                    gen_usu = :genero
                    WHERE doc_usu = :documento";
            
            $stmt = $this->db->prepare($query);
            
            $stmt->bindParam(":nombre", $data['nombre']);
            $stmt->bindParam(":apellido", $data['apellido']);
            $stmt->bindParam(":fecha_nacimiento", $data['fecha_nacimiento']);
            $stmt->bindParam(":tipo_documento", $data['tipo_documento']);
            $stmt->bindParam(":documento", $data['documento']);
            $stmt->bindParam(":direccion", $data['direccion']);
            $stmt->bindParam(":celular", $data['celular']);
            $stmt->bindParam(":celular2", $data['celular2']);
            $stmt->bindParam(":email", $data['email']);
            $stmt->bindParam(":genero", $data['genero']);
            $stmt->bindParam(":id", $id);
            
            return $stmt->execute();
        }

        // Desactivar usuario (borrado lógico)
        public function desactivarUsuario($id) {
            $query = "UPDATE usuarios SET estado = 0 WHERE doc_usu = :documento";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(":id", $id);
            return $stmt->execute();
        }

        public function Login($email) {
            $query = "CALL Login(:email)";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(":email", $email);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
    }


?>