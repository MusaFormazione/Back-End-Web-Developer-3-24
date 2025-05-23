
# 🧠 MySQL Functions - Le più Utili per lo Sviluppatore Backend

Questa guida raccoglie le principali **funzioni MySQL** utili per la manipolazione di dati, analisi e trasformazione, con esempi tratti dal database di esempio **Sakila**.

---

## 🔤 Funzioni per Stringhe

### `CONCAT()`

Unisce più stringhe insieme.

```sql
SELECT CONCAT(first_name, ' ', last_name) AS full_name
FROM actor;
```

---

### `UPPER()` / `LOWER()`

Trasforma il testo in maiuscolo o minuscolo.

```sql
-- UPPER
SELECT UCASE(first_name) AS nome_maiuscolo
FROM actor;

-- LOWER
SELECT LCASE(first_name) AS nome_maiuscolo
FROM actor;

```

---

### `SUBSTRING()` / `LEFT()` / `RIGHT()`

Estrae una parte di una stringa.

```sql
SELECT SUBSTRING(first_name, 1, 3) AS iniziali
FROM actor;

SELECT 
    CONCAT(SUBSTRING(first_name, 1, 1), 
    LOWER(SUBSTRING(first_name,2, LENGTH(first_name)))) Nome,
    last_name
FROM actor
WHERE  SUBSTRING(first_name, 1, 1) = 'P' OR  SUBSTRING(first_name, 1, 1) = SUBSTRING('ANNIBALE', 1, 1)
ORDER BY CONCAT(first_name, last_name);


SELECT LEFT(last_name, 2) AS prefisso, 
       RIGHT(last_name, 2) AS suffisso
FROM actor;


SELECT LPAD(actor_id, 3, '0') AS actor_id
FROM actor
ORDER BY actor_id;

SELECT RPAD(actor_id, 3, '0') AS actor_id
FROM actor
ORDER BY actor_id;


SELECT CAST(25.65 AS CHAR(50));
SELECT CAST('2017-08-29' AS DATE);
SELECT CAST(25.65 AS INT(2));  -- IL CAST FALLISCE NON COMPATIBILITA' TRA VALORE E TIPO
SELECT ROUND(25.65);  
SELECT CAST('Ciao' AS Binary(10))
```

---

## 🧮 Funzioni Numeriche

### `ROUND()`

Arrotonda un numero.

```sql
SELECT ROUND(rental_rate, 1) AS prezzo_arrotondato
FROM film;
```

---

### `FLOOR()` / `CEIL()`

Approssimazioni per difetto e per eccesso.

```sql
SELECT FLOOR(replacement_cost), CEIL(replacement_cost), ROUND(replacement_cost), replacement_cost
FROM film;
```

---

## 🕒 Funzioni per Date e Tempo

### `NOW()` / `CURDATE()` / `CURTIME()`

Restituiscono rispettivamente data e ora attuali, solo la data o solo l’ora.

```sql
SELECT NOW(), CURDATE(), CURTIME();
```

---

### `DATEDIFF()` / `DATE_ADD()` / `DATE_SUB()`

Lavorare con le differenze o somme sulle date.

```sql
-- Giorni trascorsi da una data
SELECT rental_id, ROUND(DATEDIFF(NOW(), return_date)/365.25) AS durata
FROM rental
WHERE return_date IS NOT NULL;

-- Data tra 10 giorni
SELECT DATE_ADD(CURDATE(), INTERVAL 12 DAY) AS data_futura;
```

---

## 🧩 Funzioni di Controllo

### `IF()` / `IFNULL()` / `NULLIF()`

Controlli logici e gestione dei valori nulli.

```sql
-- IF: condizione
SELECT first_name,
       IF(active = 1, 'attivo', 'non attivo') AS stato
FROM customer;

-- IFNULL: sostituisce il valore NULL
SELECT return_date, IFNULL(return_date, 'Non ancora restituito') AS stato_restituzione
FROM rental;

SELECT first_name, last_name, IFNULL(title, 'Nessun film') as Film FROM actor
LEFT JOIN film_actor ON film_actor.actor_id = actor.actor_id
LEFT JOIN film ON film_actor.film_id = film.film_id;

-- NULLIF: restituisce NULL se i due valori sono uguali
SELECT NULLIF(rental_duration, 0)
FROM film;
```

---

## 📊 Funzioni Aggregate

### `COUNT()` / `SUM()` / `AVG()` / `MAX()` / `MIN()`

Esempi:

```sql
SELECT COUNT(*) AS num_film,
       AVG(rental_rate) AS prezzo_medio,
       MAX(length) AS durata_max
FROM film;
```

---

## 🧪 Esercizi Proposti

### Esercizio 1
Visualizza nome e cognome degli attori in **maiuscolo**.

### Esercizio 2
Mostra per ogni cliente il numero di noleggi effettuati (`rental`) e la data dell'ultimo noleggio.

### Esercizio 3
Mostra per ogni film il **costo per minuto** (`replacement_cost / length`), arrotondato a due cifre decimali.
