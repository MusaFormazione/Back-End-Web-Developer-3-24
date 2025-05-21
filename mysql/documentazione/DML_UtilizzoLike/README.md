
# 🔍 Uso di LIKE in SQL

## ✅ Cos'è `LIKE`

L'operatore `LIKE` in SQL permette di effettuare **ricerche basate su pattern**. È molto utile quando non conosci esattamente il valore di una colonna, ma vuoi cercare **somiglianze**.

### 🔹 Caratteri jolly

- `%` corrisponde a **qualsiasi sequenza di caratteri** (anche vuota)
- `_` corrisponde a **un singolo carattere**

### 🔹 Esempi

| Pattern              | Corrispondenza                                   |
|----------------------|--------------------------------------------------|
| `'A%'`              | stringhe che iniziano con A                      |
| `'%Z'`              | stringhe che finiscono con Z                     |
| `'%CAR%'`           | stringhe che contengono la sequenza "CAR"       |
| `'____A'`           | stringhe di 5 lettere che terminano con A       |

---

# 🧪 Esercizi su LIKE + Logica Booleana

## 🔹 Esercizio 1 — Nome o Cognome contiene una parola chiave

**Obiettivo**: Trova tutti i clienti (`customer`) il cui **nome contiene "ER" oppure il cognome contiene "AN"** (case insensitive).

```sql
SELECT * FROM customer
WHERE first_name LIKE '%ER%' OR last_name LIKE '%AN%';
```

---

## 🔹 Esercizio 2 — Film con parola chiave, ma solo di una certa durata

**Obiettivo**: Trova i film (`film`) che contengono la parola **"LOVE"** nel titolo **e** hanno una durata **superiore a 100 minuti**.

```sql
SELECT * FROM film
WHERE title LIKE '%LOVE%' AND length > 100;
```

---

## 🔹 Esercizio 3 — Attori che non finiscono con "A" e che hanno una "Y" nel nome

**Obiettivo**: Trova tutti gli attori (`actor`) il cui **nome contiene la lettera "Y"** ma **non termina con la lettera "A"**.

```sql
SELECT * FROM actor
WHERE first_name LIKE '%Y%' AND first_name NOT LIKE '%A';
```
