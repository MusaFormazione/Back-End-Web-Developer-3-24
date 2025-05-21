# Esercizi sulle Query


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