
# 📘 Copiare una tabella in MySQL

In MySQL, **creare una copia di una tabella** è un'operazione comune per eseguire test, backup, esportazioni parziali o modifiche temporanee. Questo documento ti guida attraverso le **principali caratteristiche** di questa operazione, con esempi pratici.

---

## 🔁 Obiettivo base: creare una copia di una tabella esistente

### ✅ Copia completa (struttura + dati)

```sql
CREATE TABLE nuova_tabella
AS
SELECT * FROM tabella_originale;
```

> ⚠️ Questa istruzione **non copia** chiavi primarie, indici, AUTO_INCREMENT o vincoli.

---

## 🧪 Varianti possibili

### 🟡 1. Creare una copia **temporanea**

```sql
CREATE TEMPORARY TABLE tabella_temp
AS
SELECT * FROM tabella_originale;
```

- La tabella è visibile **solo nella sessione corrente**
- Viene eliminata automaticamente alla fine della sessione
- Utile per operazioni di test o intermedie

---

### 🔵 2. Copiare **solo la struttura**

```sql
CREATE TABLE nuova_tabella
AS
SELECT * FROM tabella_originale WHERE 0;
```

Oppure, per una tabella temporanea:

```sql
CREATE TEMPORARY TABLE tabella_temp
AS
SELECT * FROM tabella_originale WHERE 0;
```

- Nessun dato viene copiato
- Utile per definire strutture di staging, logging, testing

---

### 🟢 3. Copiare **solo i dati** in una tabella già esistente

```sql
INSERT INTO tabella_esistente
SELECT * FROM tabella_sorgente;
```

Oppure specificando le colonne:

```sql
INSERT INTO tabella_esistente (col1, col2)
SELECT col1, col2 FROM tabella_sorgente;
```

- La tabella deve esistere con una struttura compatibile
- I dati verranno aggiunti in append

---

## 🧪 Esempio completo

```sql
-- Creo una tabella backup con la stessa struttura ma senza dati
CREATE TABLE cliente_backup
AS SELECT * FROM cliente WHERE 0;

-- Popolo la tabella backup
INSERT INTO cliente_backup
SELECT * FROM cliente;
```

---

## 🔍 Approfondimento: copiare tutto, compresi indici e vincoli

Per replicare una tabella in modo completo (inclusi PK, indici, AUTO_INCREMENT, vincoli), utilizza:

```sql
SHOW CREATE TABLE tabella_originale;
```

Copia il risultato, rinomina la tabella e lancia manualmente il comando.

---
