# Consente di spegnere il controllo di consistenza sulle chiavi esterne
SET foreign_key_checks = 0;

# Consente di ri-eseguire lo script da 0
DROP DATABASE IF EXISTS NoleggioVeicoli;

CREATE DATABASE NoleggioVeicoli;
USE NoleggioVeicoli;

CREATE TABLE cliente(
    cliente_id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT
    -- nome
    -- cognome
    -- data_nascita
    -- luogo_nascita
    -- patente
    -- created_at TIMESTAMP
)
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_0900_ai_ci;

CREATE TABLE noleggio(
     noleggio_id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
     cliente_id INT UNSIGNED NOT NULL,
     veicolo_id INT UNSIGNED NOT NULL,
    -- data_inizio DATETIME
    -- data_fine DATETIME
    CONSTRAINT `fk_noleggio_cliente` FOREIGN KEY (cliente_id) REFERENCES cliente(cliente_id),
    CONSTRAINT `fk_noleggio_veicolo` FOREIGN KEY (veicolo_id) REFERENCES veicolo(veicolo_id)
)
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_0900_ai_ci;

CREATE TABLE veicolo(
    veicolo_id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT
    -- modello
    -- marca
    -- targa
    -- anno_immatricolazione
)
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_0900_ai_ci;

# Reimposta il controllo di consistenza sulle chiavi esterne
SET foreign_key_checks = 1;