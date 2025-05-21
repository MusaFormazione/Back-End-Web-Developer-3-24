
# 🎯 LIMIT in SQL

## ✅ Cos'è `LIMIT`

L'istruzione `LIMIT` serve a **limitare il numero di righe** restituite da una query. È particolarmente utile quando vogliamo visualizzare solo una parte dei dati, ad esempio i primi 10 risultati.

### 🔹 Sintassi base

```sql
SELECT * FROM tabella
LIMIT n;
```

Restituisce le prime `n` righe.

---

## 🔄 OFFSET

`OFFSET` viene utilizzato per **saltare un certo numero di righe** prima di cominciare a restituire i risultati.

### 🔹 Sintassi con OFFSET

```sql
SELECT * FROM tabella
LIMIT n OFFSET m;
```

- `n`: numero di righe da restituire
- `m`: numero di righe da saltare

Equivalente anche a:

```sql
SELECT * FROM tabella
LIMIT m, n;
```

(dove `m` è l'OFFSET e `n` il numero di righe)

---

# 🧪 Esercizi su LIMIT

## 🔹 Esercizio 1

**Obiettivo**: Visualizza i primi **5 clienti** (`customer`) attivi (`active = 1`).

```sql
SELECT * FROM customer
WHERE active = 1
LIMIT 5;
```

---

## ✍️ Esercizio 2 — trova tu la soluzione corretta

**Obiettivo**: Mostra i **primi 10 film** (`film`) con rating `'PG'`.

```sql
-- Suggerimento: usa WHERE + LIMIT
```

---

## ✍️ Esercizio 3 — trova tu la soluzione corretta

**Obiettivo**: Mostra i **5 clienti successivi** ai primi 5 (quindi dal 6° al 10°) nella tabella `customer`.

```sql
-- Suggerimento: usa LIMIT con OFFSET
```
