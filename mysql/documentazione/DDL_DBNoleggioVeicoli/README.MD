
# 🧾 Esercizio DDL – Agenzia di Noleggio Auto

## 📄 Abstract

Questo esercizio introduce un **piccolo database per un'agenzia di noleggio auto**, utilizzato durante la lezione per **illustrare la scrittura del codice DDL** (Data Definition Language).  
L’obiettivo è comprendere come:

- creare da zero lo schema iniziale del database,
- aggiornare la struttura delle tabelle esistenti,
- definire relazioni tra entità con chiavi esterne,
- aggiungere indici per migliorare le performance delle query.

Lo script è diviso in due sezioni:
1. **Creazione del database e delle tabelle principali**,
2. **Aggiornamento successivo** con l’aggiunta di colonne e indici.

---

## 🧱 Script DDL - Esercizio Noleggio Veicoli

### ⚙️ Setup iniziale

```sql
SET foreign_key_checks = 0;
DROP DATABASE IF EXISTS NoleggioVeicoli;
CREATE DATABASE NoleggioVeicoli;
USE NoleggioVeicoli;
```

### 🏗️ Creazione tabelle (struttura base)

- **Tabella `cliente`**
    - `cliente_id` (PK, auto_increment)
    - (altri campi da aggiungere in seguito)

- **Tabella `veicolo`**
    - `veicolo_id` (PK, auto_increment)
    - (altri campi da aggiungere in seguito)

- **Tabella `noleggio`**
    - `noleggio_id` (PK, auto_increment)
    - `cliente_id` (FK → cliente)
    - `veicolo_id` (FK → veicolo)
    - (altri campi da aggiungere in seguito)

```sql
SET foreign_key_checks = 1;
```

---

### 🔄 Aggiornamento struttura tabelle

#### 🔧 Tabella `cliente`

```sql
ALTER TABLE cliente
  ADD nome VARCHAR(45) NOT NULL,
  ADD cognome VARCHAR(45) NOT NULL,
  ADD data_nascita DATE NOT NULL,
  ADD luogo_nascita VARCHAR(100),
  ADD patente CHAR(10) NOT NULL,
  ADD data_creazione TIMESTAMP ON UPDATE CURRENT_TIMESTAMP;
```

#### 🔧 Tabella `veicolo`

```sql
ALTER TABLE veicolo
  ADD modello VARCHAR(45) NOT NULL,
  ADD marca VARCHAR(45) NOT NULL,
  ADD targa CHAR(10) NOT NULL,
  ADD anno_immatricolazione YEAR NOT NULL,
  ADD data_creazione TIMESTAMP ON UPDATE CURRENT_TIMESTAMP;
```

#### 🔧 Tabella `noleggio`

```sql
ALTER TABLE noleggio
  ADD data_inizio DATETIME NOT NULL,
  ADD data_fine DATETIME;
```

---

### 📈 Aggiunta Indici

```sql
ALTER TABLE cliente ADD INDEX ix_cognome (cognome);
ALTER TABLE veicolo ADD INDEX ix_modello_marca (modello, marca);
```
