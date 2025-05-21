
# Demo: Introduzione ai tipi di dato con DDL

In questa lezione vediamo come definire correttamente i tipi di dato in MySQL usando comandi DDL (`CREATE TABLE`).

---

## 📞 Esempio 1 – Una rubrica di contatti

Cominciamo con un esempio semplice: una rubrica.

```sql
CREATE TABLE rubrica (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50),
    cognome VARCHAR(50),
    telefono CHAR(10),
    email VARCHAR(100)
);
```

**Cosa stiamo facendo qui?**
- `INT` per l'id: perfetto per una chiave primaria numerica.
- `VARCHAR` per nomi e email: lunghezza variabile, ideale per stringhe di lunghezza incerta.
- `CHAR(10)` per il telefono: lunghezza fissa, usato qui per forzare l'inserimento corretto di numeri a 10 cifre.

Inseriamo un contatto:

```sql
INSERT INTO rubrica (nome, cognome, telefono, email)
VALUES ('Antonio', 'Rossi', '3281234567', 'antonio@example.com');
```

---

## 📅 Esempio 2 – Eventi con date e orari

Ora vediamo i tipi legati al tempo.

```sql
CREATE TABLE eventi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titolo VARCHAR(100),
    data_evento DATE,
    ora_inizio TIME,
    data_ora_creazione DATETIME DEFAULT CURRENT_TIMESTAMP
);
```

**Cosa osserviamo?**
- `DATE`, `TIME`, `DATETIME` sono tre tipi diversi e hanno scopi diversi.
- `DEFAULT CURRENT_TIMESTAMP` popola automaticamente il campo con il momento dell'inserimento.

Esempio d'inserimento:

```sql
INSERT INTO eventi (titolo, data_evento, ora_inizio)
VALUES ('Conferenza SQL', '2025-05-10', '09:00:00');
```

---

## 💶 Esempio 3 – Gestione di fatture

Qui vediamo l'utilizzo dei tipi numerici con decimali, utili per gestire importi.

```sql
CREATE TABLE fatture (
    id INT AUTO_INCREMENT PRIMARY KEY,
    numero_fattura VARCHAR(20),
    importo DECIMAL(10, 2),
    iva_percentuale TINYINT,
    totale_calcolato DECIMAL(10,2)
);
```

**Cosa considerare?**
- `DECIMAL(10,2)` è adatto per gestire soldi: 10 cifre totali, 2 decimali.
- `TINYINT` è perfetto per percentuali da 0 a 100 (range -128 a 127).

---

## ⚠️ Esempio 4 – Tabelle progettate male

Ecco un esempio di tabella fatta con scelte sbagliate. Parliamone insieme:

```sql
CREATE TABLE utenti_strani (
    id VARCHAR(10),
    nome TEXT,
    data_nascita VARCHAR(10)
);
```

**Problemi:**
- `id` come `VARCHAR`: poco efficiente per una chiave primaria.
- `nome` come `TEXT`: inutile se non serve un campo lunghissimo (e limita l'uso di indici).
- `data_nascita` come `VARCHAR`: non si possono fare query tra date, ordinamenti, confronti temporali...

---

## ❌ Altri esempi di errori comuni

### ❗ Testi dove servivano numeri

```sql
CREATE TABLE prodotti (
    codice VARCHAR(10),
    prezzo VARCHAR(20)
);
```

Il prezzo non dovrebbe mai essere un testo! Risultato: non puoi sommare, ordinare correttamente, o applicare funzioni matematiche.

---

### ❗ Campi inutilmente troppo lunghi

```sql
CREATE TABLE newsletter (
    email TEXT
);
```

`TEXT` supporta 65.535 caratteri. Ma un'email ha al massimo 254 caratteri! Meglio `VARCHAR(254)`.

---

### ❗ Scelte forzate

```sql
CREATE TABLE clienti (
    sesso CHAR(1) -- 'M' o 'F'
);
```

Meglio usare un `ENUM('M', 'F', 'Altro')` oppure una tabella `generi` a parte, per supportare più opzioni in futuro.

---

### ❗ Date errate come stringhe

```sql
CREATE TABLE accessi (
    login_time VARCHAR(25)
);
```

Risultato: niente ordinamento corretto per data, niente confronto tra orari. Soluzione: `DATETIME`.

---

## ✅ Conclusione

Quando definiamo i tipi di dato, stiamo mettendo le fondamenta del nostro database. Scelte sbagliate si pagano con lentezza, inconsistenza e query complicate. Scelte corrette rendono tutto più robusto, coerente e veloce.
