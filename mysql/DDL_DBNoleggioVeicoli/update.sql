USE NoleggioVeicoli;

-- Aggiunta dei campi mancanti

-- cliente
ALTER TABLE cliente ADD COLUMN nome VARCHAR(45) NOT NULL;
ALTER TABLE cliente ADD COLUMN cognome VARCHAR(45) NOT NULL;
ALTER TABLE cliente ADD data_nascita DATE NOT NULL;
ALTER TABLE cliente ADD luogo_nascita VARCHAR(100) NULL;
ALTER TABLE cliente ADD patente CHAR(10) NOT NULL;
ALTER TABLE cliente ADD data_creazione TIMESTAMP ON UPDATE CURRENT_TIMESTAMP;

-- veicolo
ALTER TABLE veicolo ADD COLUMN modello VARCHAR(45) NOT NULL;
ALTER TABLE veicolo ADD COLUMN marca VARCHAR(45) NOT NULL;
ALTER TABLE veicolo ADD targa CHAR(10) NOT NULL;
ALTER TABLE veicolo ADD anno_immatricolazione YEAR NOT NULL;
ALTER TABLE veicolo ADD data_creazione TIMESTAMP ON UPDATE CURRENT_TIMESTAMP;


-- noleggio
ALTER TABLE noleggio ADD COLUMN data_inizio DATETIME NOT NULL;
ALTER TABLE noleggio ADD COLUMN data_fine DATETIME NULL;


-- Aggiunta Indici
ALTER TABLE cliente ADD INDEX `ix_cognome` (cognome);
ALTER TABLE veicolo ADD INDEX `ix_modello_marca` (modello,marca);