-- Active: 1743971322762@@127.0.0.1@3306@app_vet
DELIMITER //
CREATE PROCEDURE Login(
    IN p_email VARCHAR(100)
)
BEGIN
    SELECT 
        id_usu AS id_usuario,
        nom_usu AS nombre,
        ape_usu AS apellido,
        doc_usu AS documento,
        cont_usu AS contrasena_hash,
        estado AS activo
    FROM 
        app_vet.usuarios
    WHERE 
        email_usu = p_email;
END //