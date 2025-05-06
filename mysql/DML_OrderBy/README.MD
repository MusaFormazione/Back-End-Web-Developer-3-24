
# 📊 ORDER BY in SQL

## ✅ Cos'è `ORDER BY`

L’istruzione `ORDER BY` consente di **ordinare i risultati di una query** in base a uno o più campi.

### 🔹 Ordinamento crescente e decrescente

- `ASC` = crescente (default)
- `DESC` = decrescente

### 🔹 Esempio

```sql
SELECT * FROM customer
ORDER BY last_name ASC;
```

Ordinamento crescente sul cognome.

---

## 🔄 Ordinamento su più colonne

```sql
SELECT * FROM customer
ORDER BY store_id ASC, last_name DESC;
```

Prima ordina per `store_id`, poi a parità di store per `last_name` decrescente.

---

# 🧪 Esercizi su ORDER BY

## 🔹 Esercizio 1

**Obiettivo**: Mostrare tutti i clienti (`customer`) ordinati per `last_name` in ordine decrescente.

```sql
SELECT * FROM customer
ORDER BY last_name DESC;
```

---

## ✍️ Esercizio 2 — trova tu la soluzione

**Obiettivo**: Mostra i primi 10 film (`film`) ordinati per durata (`length`) dal più lungo al più corto.

```sql
-- Suggerimento: usa ORDER BY + LIMIT
```

---

## ✍️ Esercizio 3 — trova tu la soluzione

**Obiettivo**: Elenca i clienti (`customer`) ordinati prima per `store_id` crescente e poi per `first_name` crescente.

```sql
-- Suggerimento: usa ORDER BY su più colonne
```
