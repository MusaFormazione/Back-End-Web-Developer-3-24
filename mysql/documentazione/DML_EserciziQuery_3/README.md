# 🔍 Esercizi sulle Query 2

Questa sezione contiene una serie di esercizi pratici di SQL che utilizzano il database Sakila. Gli esercizi sono progettati per aiutarti a comprendere come costruire query complesse passo dopo passo, seguendo l'approccio "divide et impera".

Ogni esercizio include:
- La descrizione del problema
- Un approccio step-by-step per la soluzione
- Le query SQL complete con spiegazioni

## 📋 Esercizio 1: Film Noleggiati Più di 30 Volte

**Obiettivo**: Trovare i film che sono stati noleggiati più di 30 volte, mostrando il titolo del film, la categoria e il numero totale di noleggi. Ordinare i risultati per numero di noleggi in ordine decrescente.

### Approccio: Divide et Impera

#### Passo 1: Trovare i film che sono stati noleggiati

Per prima cosa, dobbiamo capire come collegare le tabelle `film` e `rental`:
- La tabella `film` contiene i dati dei film
- La tabella `rental` contiene i dati dei noleggi
- Le due tabelle sono collegate tramite la tabella intermedia `inventory`

Possiamo usare INNER JOIN perché siamo interessati solo ai film che sono stati noleggiati:

```sql
SELECT *
FROM film
INNER JOIN inventory ON inventory.film_id = film.film_id
INNER JOIN rental ON rental.inventory_id = inventory.inventory_id;
```

#### Passo 2: Contare i noleggi e filtrare quelli con più di 30

Aggiungiamo il conteggio dei noleggi e filtriamo con HAVING:

```sql
SELECT title, COUNT(rental.rental_id) AS totale_noleggi
FROM film
INNER JOIN inventory ON inventory.film_id = film.film_id
INNER JOIN rental ON rental.inventory_id = inventory.inventory_id
GROUP BY film.film_id
HAVING totale_noleggi > 30;
```

#### Passo 3: Aggiungere le categorie dei film

Per aggiungere le categorie, dobbiamo collegare anche le tabelle `film_category` e `category`:

```sql
WITH first_part_of_query AS (
    SELECT
        film.film_id,
        title AS titolo,
        GROUP_CONCAT(DISTINCT category.name) AS categories
    FROM film
    INNER JOIN film_category ON film.film_id = film_category.film_id
    INNER JOIN category ON category.category_id = film_category.category_id
    GROUP BY film.film_id
)
SELECT
    titolo,
    categories,
    COUNT(rental.rental_id) AS totale_noleggi
FROM first_part_of_query
INNER JOIN inventory ON inventory.film_id = first_part_of_query.film_id
INNER JOIN rental ON rental.inventory_id = inventory.inventory_id
GROUP BY first_part_of_query.film_id, titolo
HAVING totale_noleggi > 30
ORDER BY titolo;
```

#### Passo 4: Ordinare i risultati per numero di noleggi in ordine decrescente

Modifichiamo l'ordinamento per rispettare la richiesta:

```sql
WITH first_part_of_query AS (
    SELECT
        film.film_id,
        title AS titolo,
        GROUP_CONCAT(DISTINCT category.name) AS categories
    FROM film
    INNER JOIN film_category ON film.film_id = film_category.film_id
    INNER JOIN category ON category.category_id = film_category.category_id
    GROUP BY film.film_id
)
SELECT
    titolo,
    categories,
    COUNT(rental.rental_id) AS totale_noleggi
FROM first_part_of_query
INNER JOIN inventory ON inventory.film_id = first_part_of_query.film_id
INNER JOIN rental ON rental.inventory_id = inventory.inventory_id
GROUP BY first_part_of_query.film_id, titolo
HAVING totale_noleggi > 30
ORDER BY totale_noleggi DESC;
```

---

## 📋 Esercizio 2: Fatturato Mensile del Negozio

**Obiettivo**: Calcolare il fatturato mensile del negozio per l'anno 2005, mostrando il mese, l'anno e l'importo totale. Ordinare i risultati cronologicamente.

### Approccio

1. Dalla tabella `payment` otteniamo le date e lo `staff_id`
2. Colleghiamo `payment` a `staff` e poi a `store`
3. Utilizziamo le funzioni `YEAR()` e `MONTH()` per estrarre l'anno e il mese
4. Raggruppiamo e ordiniamo i risultati

```sql
SELECT
    store.store_id,
    YEAR(payment_date) AS year,
    MONTH(payment_date) AS month,
    ROUND(SUM(amount)) AS amount
FROM payment
INNER JOIN staff ON staff.staff_id = payment.staff_id
INNER JOIN store ON store.store_id = staff.store_id
GROUP BY YEAR(payment_date), MONTH(payment_date), store.store_id
ORDER BY year DESC, month DESC;
```

---

## 📋 Esercizio 3: Clienti con Spesa Superiore a $150

**Obiettivo**: Trovare i clienti che hanno speso più di 150 dollari in totale, mostrando il loro nome, cognome, email, importo totale speso e il numero di film noleggiati.

### Approccio

1. Colleghiamo `customer` a `payment` per calcolare la spesa totale
2. Filtriamo i clienti con spesa superiore a $150
3. Colleghiamo a `rental` per contare i noleggi

```sql
WITH customer_spesa AS (
    SELECT
        customer.customer_id,
        first_name,
        last_name,
        email,
        ROUND(SUM(payment.amount)) AS spesa_totale
    FROM customer
    INNER JOIN payment ON customer.customer_id = payment.customer_id
    GROUP BY customer.customer_id
    HAVING spesa_totale > 150
)
SELECT
    first_name,
    last_name,
    email,
    spesa_totale,
    COUNT(rental.rental_id) AS noleggi
FROM customer_spesa
LEFT JOIN rental ON rental.customer_id = customer_spesa.customer_id
GROUP BY customer_spesa.customer_id;
```

---

## 📋 Esercizio 4: Durata Media del Noleggio per Categoria

**Obiettivo**: Calcolare la durata media del noleggio per categoria di film, mostrando anche il numero di noleggi e l'importo medio pagato per ciascuna categoria.

### Approccio

1. Colleghiamo `rental` a `inventory`, `film`, `film_category` e `category`
2. Utilizziamo `DATEDIFF()` per calcolare la durata del noleggio
3. Colleghiamo a `payment` per ottenere gli importi
4. Raggruppiamo per categoria

```sql
SELECT
    category.category_id,
    category.name AS category_name,
    AVG(DATEDIFF(return_date, rental_Date)) AS media,
    CONCAT(ROUND(AVG(payment.amount)), '$') AS importo_medio
FROM rental
INNER JOIN inventory ON inventory.inventory_id = rental.inventory_id
INNER JOIN film ON film.film_id = inventory.film_id
INNER JOIN film_category ON film.film_id = film_category.film_id
INNER JOIN category ON category.category_id = film_category.category_id
INNER JOIN payment ON rental.rental_id = payment.rental_id
GROUP BY category.category_id;
```

---

## 📋 Esercizio 5: Film Mai Noleggiati

**Obiettivo**: Trovare i film che non sono mai stati noleggiati, mostrando il titolo, la categoria e il prezzo di noleggio. Ordinare i risultati per categoria e titolo.

### Approccio

Per trovare i film mai noleggiati, dobbiamo usare LEFT JOIN e cercare quelli senza corrispondenze nella tabella rental:

```sql
SELECT 
    title, 
    rental_rate, 
    category.name AS category
FROM film
LEFT JOIN inventory ON inventory.film_id = film.film_id
LEFT JOIN rental ON rental.inventory_id = inventory.inventory_id
LEFT JOIN film_category ON film.film_id = film_category.film_id
LEFT JOIN category ON film_category.category_id = category.category_id
WHERE rental.rental_id IS NULL
ORDER BY category, title;
```

---

## 🔑 Concetti Chiave

Questi esercizi illustrano diversi concetti importanti di SQL:

1. **JOIN multipli**: Collegare più tabelle per ottenere i dati necessari
2. **Funzioni di aggregazione**: COUNT(), SUM(), AVG()
3. **Common Table Expressions (CTE)**: Utilizzare WITH per creare query temporanee
4. **Funzioni di data**: YEAR(), MONTH(), DATEDIFF()
5. **Clausole GROUP BY e HAVING**: Per aggregare e filtrare i risultati
6. **Formattazione dei risultati**: CONCAT(), ROUND()

Questi concetti sono fondamentali per costruire query SQL complesse ed efficaci.