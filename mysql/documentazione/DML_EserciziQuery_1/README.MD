# 🔍 Esercizi sulle Query 2

Questa sezione contiene una serie di esercizi pratici di SQL che utilizzano il database Sakila. Gli esercizi sono progettati per aiutarti a comprendere come costruire query complesse e analizzare dati relazionali.

## 📋 Esercizio 1 - Numero di Film per Categoria

**Obiettivo**: Contare quanti film ci sono in ciascuna categoria.

```sql
SELECT
    film_category.category_id,
    category.name AS categoria_film,
    COUNT(film_id) AS film_totali
FROM film_category
INNER JOIN category ON film_category.category_id = category.category_id
GROUP BY film_category.category_id;
```

Questa query:
- Unisce le tabelle `film_category` e `category` usando l'ID della categoria
- Raggruppa i risultati per categoria
- Conta quanti film ci sono in ciascuna categoria
- Mostra l'ID della categoria, il nome della categoria e il conteggio totale dei film

## 📋 Esercizio 2 - Categorie di Film Preferite dai Clienti

**Obiettivo**: Per ogni cliente, trovare le prime 3 categorie di film preferite.

```sql
SELECT
    customer_id as id_customer, first_name, last_name,
    (
        SELECT GROUP_CONCAT(name) FROM (
            SELECT category.name
            FROM customer
            INNER JOIN rental ON rental.customer_id = customer.customer_id
            INNER JOIN inventory ON inventory.inventory_id = rental.inventory_id
            INNER JOIN film ON film.film_id = inventory.film_id
            INNER JOIN film_category ON film.film_id = film_category.film_id
            INNER JOIN category ON film_category.category_id = category.category_id
            WHERE customer.customer_id = id_customer
            GROUP BY category.category_id, customer.customer_id
            ORDER BY customer.customer_id, count(customer.customer_id) desc
            LIMIT 3
            ) as t
        ) as categorie_preferite
FROM customer;
```

Questa query complessa:
- Seleziona l'ID, nome e cognome di ogni cliente
- Per ogni cliente, esegue una subquery che:
    - Unisce le tabelle `customer`, `rental`, `inventory`, `film`, `film_category` e `category`
    - Filtra i risultati per il cliente corrente
    - Raggruppa per categoria e cliente
    - Ordina per conteggio decrescente (le categorie più noleggiate prima)
    - Limita i risultati alle prime 3 categorie
    - Concatena i nomi delle categorie in un'unica stringa
- Mostra l'ID del cliente, nome, cognome e le categorie preferite

## 📋 Esercizio 3 - Numero di Film Presenti in Ciascuno Store

### Parte 1: Conteggio dei Supporti Fisici (DVD)

**Obiettivo**: Contare quanti supporti fisici (DVD) ci sono in ciascuno store.

```sql
SELECT
    store.store_id,
    COUNT(inventory.film_id) AS numero_supporti
FROM inventory
     INNER JOIN store ON store.store_id = inventory.store_id
GROUP BY store_id;
```

Questa query:
- Unisce le tabelle `inventory` e `store`
- Raggruppa per store_id
- Conta il numero totale di film nell'inventario per ciascuno store
- Questo conteggio include copie multiple dello stesso film

### Parte 2: Conteggio dei Titoli Unici

**Obiettivo**: Contare quanti titoli di film unici ci sono in ciascuno store.

```sql
SELECT
    store_id,
    COUNT(title) AS numero_titoli
FROM (
     SELECT
         store.store_id,
         title
     FROM film
          INNER JOIN inventory ON inventory.film_id = film.film_id
          INNER JOIN store ON store.store_id = inventory.store_id
     GROUP BY store_id, film.film_id
 ) as film_store
GROUP BY store_id
ORDER BY store_id;
```

Questa query:
- Crea una subquery che:
    - Unisce le tabelle `film`, `inventory` e `store`
    - Raggruppa per store_id e film_id per ottenere titoli unici per store
- Nella query esterna, conta i titoli per ciascuno store
- Ordina i risultati per store_id

### Versione Alternativa con DISTINCT

```sql
SELECT
    s.store_id,
    COUNT(DISTINCT f.film_id) AS numero_titoli
FROM store s
     INNER JOIN inventory i ON i.store_id = s.store_id
     INNER JOIN film f ON f.film_id = i.film_id
GROUP BY s.store_id;
```

Questa versione più concisa:
- Usa l'operatore DISTINCT per contare solo i film unici
- Produce lo stesso risultato della query precedente ma con meno codice

## 📋 Esercizio 4 - Film Presenti Solo in Uno dei Due Store

**Obiettivo**: Trovare i film che sono presenti solo in uno dei due store, non in entrambi.

```sql
SELECT
    'SOLO IN STORE 1' as store_id,
    COUNT(title) AS number,
    GROUP_CONCAT(title) as titles
FROM film
WHERE
  film_id IN (
    SELECT film_id
    FROM inventory
    WHERE store_id = 1
  )
  AND film_id NOT IN (
    SELECT film_id
    FROM inventory
    WHERE store_id = 2
  )
GROUP BY store_id
UNION
SELECT
    'SOLO IN STORE 2' as store_id,
    COUNT(title) AS number,
    GROUP_CONCAT(title) as titles
FROM film
WHERE
    film_id IN (
        SELECT film_id
        FROM inventory
        WHERE store_id = 2
    )
    AND film_id NOT IN (
        SELECT film_id
        FROM inventory
        WHERE store_id = 1
    );
```

Questa query:
- Usa due subquery unite con UNION
- La prima parte trova i film presenti solo nello store 1:
    - Seleziona i film che sono nell'inventario dello store 1
    - Esclude quelli che sono anche nell'inventario dello store 2
- La seconda parte trova i film presenti solo nello store 2:
    - Seleziona i film che sono nell'inventario dello store 2
    - Esclude quelli che sono anche nell'inventario dello store 1
- Per ciascun gruppo, mostra:
    - L'identificativo dello store
    - Il conteggio dei film
    - Un elenco concatenato dei titoli

### Approccio Alternativo con GROUP_CONCAT e HAVING

```sql
SELECT
    f.film_id,
    f.title,
    GROUP_CONCAT(i.store_id) AS negozio_disponibilita,
    GROUP_CONCAT(DISTINCT 'Store: ',i.store_id) AS negozio_disponibilita2,
    COUNT(i.inventory_id) AS numero_totale_copie,
    COUNT(DISTINCT i.store_id) AS numero_di_store_coinvolti
FROM inventory AS i
     INNER JOIN film AS f ON f.film_id = i.film_id
GROUP BY f.film_id
HAVING COUNT(DISTINCT i.store_id) = 1;
```

Questo approccio alternativo:
- Unisce le tabelle `inventory` e `film`
- Raggruppa per film_id
- Usa GROUP_CONCAT per mostrare in quali store è disponibile ciascun film
- Conta il numero totale di copie e il numero di store coinvolti
- Usa HAVING per filtrare solo i film disponibili in esattamente uno store

## 📋 Esercizio 5 - Film Non Presenti in Nessuno Store

**Obiettivo**: Trovare i film che non sono presenti in nessuno dei due store.

### Approccio 1: Usando LEFT JOIN

```sql
SELECT
    f.film_id,
    f.title
FROM film f
LEFT JOIN inventory i ON i.film_id = f.film_id
WHERE i.film_id IS NULL;
```

Questa query:
- Esegue un LEFT JOIN tra `film` e `inventory`
- Filtra per i record dove l'inventory.film_id è NULL
- Questi sono i film che non hanno corrispondenze nella tabella inventory

### Approccio 2: Usando LEFT JOIN con GROUP BY e HAVING

```sql
SELECT
       f.film_id,
       f.title,
       COUNT(i.film_id) as count
FROM film f
LEFT JOIN inventory i ON i.film_id = f.film_id
GROUP BY f.film_id
HAVING count = 0;
```

Questa query:
- Esegue un LEFT JOIN tra `film` e `inventory`
- Raggruppa per film_id
- Conta le corrispondenze nella tabella inventory
- Filtra per i film con conteggio zero

### Approccio 3: Usando NOT IN

```sql
SELECT
    film_id, title
FROM film
WHERE
    film_id NOT IN (SELECT film_id FROM inventory);
```

Questa query:
- Seleziona i film il cui ID non è presente nella tabella inventory
- È più concisa ma potrebbe essere meno efficiente su database molto grandi

### Approccio 4: Usando NOT IN con Filtro su Store

```sql
SELECT
    film_id, title
FROM film
WHERE
    film_id NOT IN (
        SELECT film_id
        FROM inventory
        WHERE store_id IN (1, 2)
    );
```

Questa query:
- Seleziona i film il cui ID non è presente nell'inventario degli store 1 e 2
- È più specifica riguardo agli store da considerare

## 🔑 Operatori Logici: Esempi Pratici

Alla fine del file, ci sono alcuni esempi che illustrano l'uso degli operatori logici OR, XOR e AND:

```sql
-- Esempio di OR: restituisce TRUE se almeno una condizione è vera
SELECT film_id
FROM inventory
WHERE store_id = 1 OR store_id = 2;

-- Esempio di XOR: restituisce TRUE se esattamente una condizione è vera
SELECT film_id
FROM inventory
WHERE store_id = 1 XOR store_id = 2;

-- Esempio di AND: restituisce TRUE solo se entrambe le condizioni sono vere
SELECT film_id
FROM inventory
WHERE store_id = 1 AND store_id = 2;
```

Questi esempi mostrano come gli operatori logici influenzano i risultati delle query:
- OR: include i record che soddisfano almeno una delle condizioni
- XOR: include solo i record che soddisfano esattamente una delle condizioni
- AND: include solo i record che soddisfano entrambe le condizioni (in questo caso specifico, nessun record soddisferà la condizione poiché un film non può essere contemporaneamente in due store diversi)