-- Active: 1743971322762@@127.0.0.1@3306@app_vet
DROP DATABASE IF EXISTS app_vet;
CREATE DATABASE IF NOT EXISTS app_vet;
CREATE TABLE app_vet.usuarios(
    id_usu INT AUTO_INCREMENT PRIMARY KEY,
    nom_usu VARCHAR(100) NOT NULL,
    ape_usu VARCHAR(100) NOT NULL,
    fec_nac_usu DATE NOT NULL,
    tip_doc_usu VARCHAR(10) NOT NULL,
    doc_usu VARCHAR(20) UNIQUE NOT NULL,INDEX(doc_usu),
    dir_usu VARCHAR(100) NOT NULL,
    cel_usu VARCHAR(20) NOT NULL,
    cel2_usu VARCHAR(20),
    email_usu VARCHAR(100) UNIQUE NOT NULL,INDEX(email_usu),
    cont_usu VARCHAR(255) NOT NULL,
    gen_usu VARCHAR(100) NOT NULL,
    estado BOOLEAN DEFAULT(1) NOT NULL,
    fec_cre_usu DATE DEFAULT(NOW())
);

CREATE TABLE app_vet.mascotas(
    id_mas INT AUTO_INCREMENT PRIMARY KEY,
    nom_mas VARCHAR(100) NOT NULL,
    esp_mas VARCHAR(100) NOT NULL,
    col_mas VARCHAR(100) NOT NULL,
    raz_mas VARCHAR(100) NOT NULL,
    ali_mas VARCHAR(100) NOT NULL,
    fec_nac_mas DATE NOT NULL,
    pes_mas FLOAT(12,2) UNSIGNED NOT NULL,
    gen_mas VARCHAR(20) NOT NULL,
    id_pro_mas VARCHAR(20) NOT NULL,INDEX(id_pro_mas),FOREIGN KEY (id_pro_mas) REFERENCES usuarios(doc_usu) ON DELETE CASCADE ON UPDATE CASCADE,
    estado BOOLEAN DEFAULT(1),
    fec_cre_mas DATE DEFAULT(NOW())
);