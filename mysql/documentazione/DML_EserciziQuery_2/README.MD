# Esercizi sulle Query 2


#### 1 - **Quanti film ha fatto ciascun attore? Ottenere, nome cognome e numero di film.**

```sql

SELECT 
    a.first_name AS nome,
    a.last_name AS cognome,
    COUNT(fa.film_id) AS numero_film
FROM 
    actor a
INNER JOIN 
    film_actor fa ON a.actor_id = fa.actor_id
GROUP BY 
    a.actor_id, a.first_name, a.last_name
ORDER BY 
    numero_film DESC;


```

-----

#### 2 - **Tre nazioni con più customer e quanti. Visualizza la nazione e il numero di customer.**

```sql 

SELECT 
    co.country AS nazione,
    COUNT(c.customer_id) AS numero_customer
FROM 
    customer c
JOIN 
    address a ON c.address_id = a.address_id
JOIN 
    city ci ON a.city_id = ci.city_id
JOIN 
    country co ON ci.country_id = co.country_id
GROUP BY 
    co.country
ORDER BY 
    numero_customer DESC
LIMIT 3;


```

-----

#### 3 - **Tre nazioni con più customer e quanti. Visualizza la nazione e il numero di customer.**

```sql

(
  SELECT 
    co.country AS nazione,
    COUNT(c.customer_id) AS numero_customer
  FROM 
    customer c
  INNER JOIN address a ON c.address_id = a.address_id
  INNER JOIN city ci ON a.city_id = ci.city_id
  INNER JOIN country co ON ci.country_id = co.country_id
  GROUP BY co.country
  ORDER BY numero_customer DESC
  LIMIT 3
)
UNION
(
  SELECT 
    co.country AS nazione,
    COUNT(c.customer_id) AS numero_customer
  FROM 
    customer c
  INNER JOIN address a ON c.address_id = a.address_id
  INNER JOIN city ci ON a.city_id = ci.city_id
  INNER JOIN country co ON ci.country_id = co.country_id
  WHERE co.country = 'Italy'
  GROUP BY co.country
);

```

-----

#### 4 - **Ottenere lo store che ha incassato di più, insieme con i dati del suo manager.**

```sql

SELECT 
    s.store_id,
    SUM(p.amount) AS totale_incassato,
    st.first_name AS manager_nome,
    st.last_name AS manager_cognome,
    st.email AS manager_email
FROM 
    payment p
INNER JOIN customer c ON p.customer_id = c.customer_id
INNER JOIN store s ON c.store_id = s.store_id
INNER JOIN staff st ON s.manager_staff_id = st.staff_id
GROUP BY 
    s.store_id, st.first_name, st.last_name, st.email
ORDER BY 
    totale_incassato DESC
LIMIT 1;

```

-----

#### 5 - NUMERO DI FILM PER CATEGORIA

```sql

SELECT 
    category.name, 
    COUNT(*) AS film  
FROM category
INNER JOIN film_category ON film_category.category_id = category.category_id
INNER JOIN film ON film_category.film_id = film.film_id
GROUP BY category.category_id
ORDER BY film DESC;

```

#### 6 - CATEGORIE DI FILM PREFERITE DAI CLIENTI (PER OGNI CLIENTI LE PRIME 3)

```sql

SELECT category.name AS categoria
FROM category
         INNER JOIN film_category ON film_category.category_id = category.category_id
         INNER JOIN film ON film.film_id = film_category.film_id
         INNER JOIN inventory ON inventory.film_id = film.film_id
         INNER JOIN rental ON rental.inventory_id = inventory.inventory_id
         INNER JOIN customer ON customer.customer_id = rental.customer_id
WHERE customer.customer_id = 9
GROUP BY customer.customer_id, category.category_id
ORDER BY customer.customer_id DESC, COUNT(*) DESC
LIMIT 2 OFFSET 1;

SELECT 
    (
        SELECT category.name AS categoria
        FROM category
                 INNER JOIN film_category ON film_category.category_id = category.category_id
                 INNER JOIN film ON film.film_id = film_category.film_id
                 INNER JOIN inventory ON inventory.film_id = film.film_id
                 INNER JOIN rental ON rental.inventory_id = inventory.inventory_id
                 INNER JOIN customer ON customer.customer_id = rental.customer_id
        WHERE customer.customer_id = ext_cust.customer_id
        GROUP BY customer.customer_id, category.category_id
        ORDER BY customer.customer_id DESC, COUNT(*) DESC
        LIMIT 1
    ) as top_1,
    (
        SELECT category.name AS categoria
        FROM category
              INNER JOIN film_category ON film_category.category_id = category.category_id
              INNER JOIN film ON film.film_id = film_category.film_id
              INNER JOIN inventory ON inventory.film_id = film.film_id
              INNER JOIN rental ON rental.inventory_id = inventory.inventory_id
              INNER JOIN customer ON customer.customer_id = rental.customer_id
         WHERE customer.customer_id = ext_cust.customer_id
         GROUP BY customer.customer_id, category.category_id
         ORDER BY customer.customer_id DESC, COUNT(*) DESC
         LIMIT 1 OFFSET 1
    ) as top_2,
    (
        SELECT category.name AS categoria
        FROM category
              INNER JOIN film_category ON film_category.category_id = category.category_id
              INNER JOIN film ON film.film_id = film_category.film_id
              INNER JOIN inventory ON inventory.film_id = film.film_id
              INNER JOIN rental ON rental.inventory_id = inventory.inventory_id
              INNER JOIN customer ON customer.customer_id = rental.customer_id
        WHERE customer.customer_id = ext_cust.customer_id
        GROUP BY customer.customer_id, category.category_id
        ORDER BY customer.customer_id DESC, COUNT(*) DESC
        LIMIT 1 OFFSET 2
    ) as top_3,
    first_name, last_name, customer_id 
FROM customer AS ext_cust

```

#### 7 - NUMERO DI FILM PRESENTI IN CIASCUNO STORE

```sql

SELECT
    store.store_id,
    COUNT(DISTINCT film.film_id) as numero_film
FROM store
         INNER JOIN inventory ON store.store_id = inventory.store_id
         INNER JOIN film ON inventory.film_id = film.film_id
GROUP BY store.store_id
ORDER BY store.store_id;


```

#### 8 - CI SONO FILM PRESENTI SOLO IN UNO DEI 2 STORE ?? SE SI' QUANTI E QUALI?

```sql 

SELECT
    'SOLO IN STORE 1' as store_id,
    COUNT(title) AS numero,
    GROUP_CONCAT(title) as titoli
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


#### 9 - SE CI SONO FILM NON PRESENTI IN NESSUNO DEI 2 STORE ?? SE SI' QUANTI E QUALI?

```sql 
SELECT 
    f.title AS titolo_film,
    f.film_id
FROM 
    film f
WHERE 
    f.film_id NOT IN (
        SELECT DISTINCT film_id 
        FROM inventory
    )
ORDER BY 
    f.title;
```