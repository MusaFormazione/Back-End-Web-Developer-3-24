
# 📊 Aggregazioni in SQL

## ✅ Funzioni di aggregazione principali

Le funzioni di aggregazione permettono di **riassumere i dati**. Le più comuni sono:

- `COUNT(*)`: conta il numero di righe
- `SUM(colonna)`: somma dei valori
- `AVG(colonna)`: media dei valori
- `MIN(colonna)`: valore minimo
- `MAX(colonna)`: valore massimo

---

## 🧩 GROUP BY

`GROUP BY` permette di **raggruppare i dati** per uno o più campi, applicando le funzioni di aggregazione a ciascun gruppo.

### 🔹 Esempio

```sql
SELECT store_id, COUNT(*) AS numero_clienti
FROM customer
GROUP BY store_id;
```

---

## 🧪 Esercizi su Aggregazioni

## 🔹 Esercizio 1

**Obiettivo**: Conta quanti clienti (`customer`) ci sono per ciascun negozio (`store_id`).

```sql
SELECT store_id, COUNT(*) AS numero_clienti
FROM customer
GROUP BY store_id;
```

---

## ✍️ Esercizio 2 — trova tu la soluzione

**Obiettivo**: Calcola la durata media (`length`) dei film (`film`) per ciascun rating.

```sql
-- Suggerimento: usa AVG con GROUP BY su rating
```

---

## ✍️ Esercizio 3 — trova tu la soluzione

**Obiettivo**: Trova il numero totale di noleggi (`rental`) effettuati da ciascun cliente (`customer_id`).

```sql
-- Suggerimento: usa COUNT con GROUP BY su customer_id
```
