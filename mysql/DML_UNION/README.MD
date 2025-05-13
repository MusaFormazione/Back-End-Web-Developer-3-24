# 🔀 UNION in SQL

## ✅ Cos'è una UNION

La `UNION` serve a **combinare i risultati di due o più query SELECT** in un unico set di risultati.

> Le colonne devono avere lo **stesso numero, tipo e ordine**.

---

## 🔹 Differenza tra UNION e UNION ALL

### 🔸 UNION
Unisce i risultati ed **elimina i duplicati**.

```sql
SELECT first_name FROM customer
UNION
SELECT first_name FROM staff;
```

### 🔸 UNION ALL
Unisce i risultati e **mantiene anche i duplicati**.

```sql
SELECT first_name FROM customer
UNION ALL
SELECT first_name FROM staff;
```

---

## 🧠 Uso avanzato: UNION con sottoquery

A volte è utile **usare una UNION come sottoquery**, ad esempio per applicare filtri o aggregazioni **sul risultato unificato**.

```sql
SELECT 
    store_staff, 
    ROUND(spesa) AS spesa 
FROM (
    SELECT CONCAT(staff_id, ' STAFF_ID') AS store_staff, SUM(amount) AS spesa
    FROM payment
    GROUP BY staff_id
    UNION ALL
    SELECT CONCAT(store_id, ' STORE_ID'), SUM(amount)
    FROM payment
    INNER JOIN customer ON customer.customer_id = payment.customer_id
    GROUP BY store_id
) AS result
WHERE store_staff LIKE '%STAFF_ID%';
```

---

## ⚠️ Attenzione
- Le query unite devono avere lo **stesso numero di colonne**.
- I **tipi di dato** devono essere compatibili.
- I **nomi delle colonne** sono presi **solo dalla prima query**.

---

# 🧪 Esercizi su UNION

## 🔹 Esercizio 1 — da svolgere insieme

**Obiettivo**: Ottieni una lista unica di tutti i nomi usati da `customer` e `staff`.

```sql
SELECT first_name FROM customer
UNION
SELECT first_name FROM staff;
```

---

## ✍️ Esercizio 2 — prova tu

**Obiettivo**: Mostra l'elenco completo degli ID dei film **presenti** o **mai noleggiati**, indicando la fonte (es. `RENTED`, `NOT RENTED`).

```sql
-- Suggerimento: usa UNION ALL tra due query con una colonna costante tipo 'RENTED' o 'NOT RENTED'
```

---

## ✍️ Esercizio 3 — prova tu

**Obiettivo**: Elenca tutti i pagamenti effettuati **dai clienti** oppure **dai membri dello staff** (ipotizzando che entrambi possano fare pagamenti).

```sql
-- Suggerimento: usa UNION tra SELECT su payment unita a customer e una unita a staff
```
