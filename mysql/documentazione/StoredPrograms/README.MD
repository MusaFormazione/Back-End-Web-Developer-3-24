
# 📦 Stored Procedure e Stored Function in MySQL

Le Stored Procedure e le Stored Function permettono di incapsulare logica SQL riutilizzabile all'interno del database.

---

## ▶️ Stored Procedure

Blocchi riutilizzabili che possono accettare parametri ed eseguire operazioni complesse.

### Esempio

```sql
DELIMITER $$

CREATE PROCEDURE film_by_rating(IN rating_val VARCHAR(10))
BEGIN
    SELECT title, rating FROM film WHERE rating = rating_val;
END $$

DELIMITER ;

-- Chiamata:
CALL film_by_rating('PG');
```

---

## ▶️ Stored Function

Restituiscono un valore e possono essere usate direttamente nelle query.

### Esempio

```sql
DELIMITER $$

CREATE FUNCTION costo_per_minuto(film_id INT)
RETURNS DECIMAL(5,2)
DETERMINISTIC
BEGIN
    DECLARE costo DECIMAL(5,2);
    DECLARE durata INT;

    SELECT replacement_cost, length
    INTO costo, durata
    FROM film
    WHERE film.film_id = film_id;

    RETURN ROUND(costo / durata, 2);
END $$

DELIMITER ;

-- Uso:
SELECT title, costo_per_minuto(film_id) AS costo_minuto
FROM film;
```

---

## 🧪 Esercizi

### Esercizio 1
Crea una **stored procedure** che, dato un `customer_id`, mostri tutti i noleggi effettuati.

### Esercizio 2
Crea una **stored function** che, dato un `film_id`, restituisca il costo medio giornaliero (`replacement_cost / rental_duration`).

