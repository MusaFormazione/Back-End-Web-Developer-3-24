```sql

CREATE TEMPORARY TABLE address_city (
    address_id INT,
    city VARCHAR(50)
);

INSERT INTO address_city (city) VALUES ('mILANO');

SELECT * FROM address_city;


DROP TEMPORARY TABLE address_city;
CREATE TEMPORARY TABLE address_city
SELECT address_id, city FROM address
INNER JOIN city ON address.city_id = city.city_id;

CREATE TABLE customer_city
SELECT customer_id, first_name, last_name, city FROM customer
INNER JOIN address_city ON address_city.address_id = customer.address_id;

SELECT * FROM customer_city;

INSERT INTO actor (last_name, first_name) VALUES ('Cruise','Tam');

CREATE TABLE actor_wise_copy
SELECT *
FROM actor;

SHOW TABLES;

SELECT * FROM actor_wise_copy;

CREATE TABLE actor_wise_copy_2
SELECT actor.actor_id as actor_actor_id, 
       actor.first_name as actor_first_name, 
       actor.last_name  as actor_last_name, 
       actor_wise_copy.actor_id,
       actor_wise_copy.first_name, 
       actor_wise_copy.last_name  
FROM actor
INNER JOIN actor_wise_copy ON actor.actor_id = actor_wise_copy.actor_id;

SELECT * FROM actor_wise_copy_2
WHERE actor_id > 10;
```