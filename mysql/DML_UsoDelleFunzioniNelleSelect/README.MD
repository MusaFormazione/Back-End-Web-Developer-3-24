## Esercizi SQL su Sakila: Uso delle Funzioni nelle SELECT

### ✨ Livello Base

#### 1. Lunghezza dei titoli dei film

> Mostra la lunghezza del titolo di ciascun film.

```sql
SELECT title, LENGTH(title) AS title_length
FROM film
ORDER BY title_length DESC;
```

#### 2. Durata totale del noleggio

> Calcola il costo totale del noleggio in base alla durata e al prezzo.

```sql
SELECT rental_duration, rental_rate, rental_duration * rental_rate AS total_cost
FROM film;
```

#### 3. Nome tutto maiuscolo dei clienti

> Converte il nome del cliente in maiuscolo.

```sql
SELECT first_name, last_name, UPPER(first_name) AS first_name_upper
FROM customer;
```

---

### ⚙️ Livello Intermedio

#### 4. Prime tre lettere dei titoli dei film

> Estrai le prime 3 lettere dal titolo del film.

```sql
SELECT title, LEFT(title, 3) AS prefix
FROM film;
```

#### 5. Età del film in anni

> Calcola quanti anni ha ogni film rispetto all'anno corrente.

```sql
SELECT title, release_year, YEAR(CURDATE()) - release_year AS film_age
FROM film;
```

#### 6. Nome e cognome concatenati

> Crea il nome completo del cliente.

```sql
SELECT CONCAT(first_name, ' ', last_name) AS full_name
FROM customer;
```

---

### 🔍 Livello Avanzato

#### 7. Numero di film per rating

> Conta i film per ciascun rating (es. PG, G, R).

```sql
SELECT rating, COUNT(*) AS total_films
FROM film
GROUP BY rating;
```

#### 8. Giorno della settimana del pagamento

> Mostra in quale giorno della settimana è avvenuto ogni pagamento.

```sql
SELECT payment_id, DATE(payment_date) AS date_only, DAYNAME(payment_date) AS weekday
FROM payment;
```

#### 9. Media degli importi arrotondata

> Calcola la media degli importi dei pagamenti, arrotondata a due decimali.

```sql
SELECT ROUND(AVG(amount), 2) AS avg_payment
FROM payment;
```