# 🗄️ Modificare la Struttura di un Database in MySQL

Guida pratica per imparare a **modificare la struttura** di un database MySQL esistente, usando i comandi `ALTER`, `RENAME`, `DROP` e altro.

---

## 📌 Operazioni Disponibili

- Aggiungere colonne
- Modificare colonne (tipo, nome)
- Rinomina tabelle, colonne, indici
- Eliminare colonne, tabelle, indici
- Aggiungere vincoli (chiavi esterne)

---

## 🧱 Aggiungere Colonne

```sql
ALTER TABLE actor_copy ADD born_in VARCHAR(45) NULL;
ALTER TABLE actor_copy ADD born_in VARCHAR(45) NULL FIRST;
ALTER TABLE actor_copy ADD born_in VARCHAR(45) NULL AFTER last_name;
```

> Se non specificato, la colonna viene aggiunta in coda. Puoi usare `FIRST` o `AFTER colonna`.

---

## 🧩 Modificare Colonne

### Modificare tipo e nome (con `CHANGE`)

```sql
ALTER TABLE actor_copy CHANGE last_update_time last_update TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP;
```

> `CHANGE` richiede nome attuale, nuovo nome e **tutti** i dettagli del tipo.

### Modificare solo tipo (con `MODIFY`)

```sql
ALTER TABLE actor_copy MODIFY first_name CHAR(45) NOT NULL;
```

> Più semplice, ma **non cambia il nome** della colonna.

---

## 🏷 Rinomina Tabelle, Colonne e Indici

```sql
RENAME TABLE actual_name TO future_name;

ALTER TABLE actor_copy RENAME COLUMN last_update_time TO last_update;
ALTER TABLE actor_copy RENAME KEY idx_actor_last_name TO idx_actor_last_name_1;
```

> Alcune operazioni sono **online DDL**: modificano solo i metadati, senza toccare i dati reali.

---

## ❌ Eliminare Colonne, Indici e Chiavi Primarie

```sql
ALTER TABLE actor_copy DROP COLUMN born_in;
ALTER TABLE actor_copy DROP INDEX idx_born_in;
ALTER TABLE nome_tabella DROP PRIMARY KEY;
```

> Gli indici non si modificano: si rimuovono e si ricreano.

---

## 🔗 Aggiungere una Chiave Esterna

```sql
ALTER TABLE ordine
ADD CONSTRAINT fk_cliente_id
FOREIGN KEY (cliente_id)
REFERENCES cliente(id);
```

Con azione:

```sql
ALTER TABLE ordine
ADD CONSTRAINT fk_cliente_id
FOREIGN KEY (cliente_id)
REFERENCES cliente(id)
ON DELETE CASCADE;
```

---

## 📦 Rinomina Tabelle e Database

```sql
ALTER TABLE no_pk RENAME TO something_different;
-- oppure
ALTER TABLE no_pk RENAME something_different;
```

Per "rinominare" un database:

```sql
CREATE DATABASE nuovo_db;
RENAME TABLE vecchio_db.tabella TO nuovo_db.tabella;
```

---

## 🗑 Eliminare Tabelle o Database

```sql
DROP TABLE nome_tabella;
DROP DATABASE nome_database;
```

Con protezione:

```sql
DROP TABLE IF EXISTS nome_tabella;
DROP DATABASE IF EXISTS nome_database;
```

---

## 🧪 Esercizi Proposti

### Esercizio 1
Crea una tabella `libri` con:
- `id` INT PRIMARY KEY AUTO_INCREMENT
- `titolo` VARCHAR(100)
- `prezzo` DECIMAL(5,2)

Poi:
- Rinomina la tabella in `catalogo`
- Rinomina `titolo` in `nome_libro`
- Cambia `prezzo` in `costo` di tipo `FLOAT`

### Esercizio 2
Aggiungi una colonna `data_pubblicazione` di tipo `DATE` dopo `nome_libro`.

### Esercizio 3
Aggiungi una chiave esterna alla tabella `catalogo`, chiamata `fk_autore_id`, che referenzia `id` della tabella `autori`.

---

Corso: **Backend Web Development**  
Trainer: **Antonio Bruno**

---

## 🧭 Aggiungere e Rimuovere Indici

Gli indici migliorano le prestazioni delle query, in particolare quelle con condizioni `WHERE` o `JOIN`.

### ➕ Aggiungere un Indice

```sql
CREATE INDEX idx_nome_colonna
ON nome_tabella (colonna);
```

Esempio:

```sql
CREATE INDEX idx_last_name
ON actor_copy (last_name);
```

Puoi anche creare indici su più colonne:

```sql
CREATE INDEX idx_nome_cognome
ON persone (nome, cognome);
```

---

### ❌ Rimuovere un Indice

```sql
ALTER TABLE nome_tabella
DROP INDEX nome_indice;
```

Esempio:

```sql
ALTER TABLE actor_copy
DROP INDEX idx_last_name;
```

> 🔁 Ricorda: **gli indici non si modificano**. Se devi cambiarli, eliminali e ricreali.
