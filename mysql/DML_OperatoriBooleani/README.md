
# 🧠 Operatori Booleani in SQL: AND, OR, NOT e Uso delle Parentesi

## ✅ Operatori principali

- `AND`: restituisce `TRUE` solo se **entrambe** le condizioni sono vere.
- `OR`: restituisce `TRUE` se **almeno una** delle condizioni è vera.
- `NOT`: inverte il valore booleano.

---

## ⚠️ Ordine di Precedenza

In SQL (e quindi anche in MySQL), gli operatori vengono valutati secondo quest’ordine:

```
1. NOT
2. AND
3. OR
```

Questo significa che l'espressione:

```sql
A AND B OR C
```

viene interpretata come:

```sql
(A AND B) OR C
```

e **non** come:

```sql
A AND (B OR C)
```

---

## 🧩 Uso delle Parentesi

Per cambiare l’ordine di valutazione, dobbiamo usare le **parentesi**.

**Esempio**:

```sql
SELECT * FROM customer
WHERE store_id = 1 AND first_name = 'MARY' OR last_name = 'SMITH';
```

Questo viene interpretato così:

```sql
( store_id = 1 AND first_name = 'MARY' ) OR last_name = 'SMITH'
```

Se invece vogliamo che la condizione `first_name = 'MARY' OR last_name = 'SMITH'` sia valutata per prima, dobbiamo scrivere:

```sql
SELECT * FROM customer
WHERE store_id = 1 AND (first_name = 'MARY' OR last_name = 'SMITH');
```

---

# 🧪 Esercizi sul database Sakila

> Assicurati che il database `sakila` sia stato caricato e sia disponibile.

---

## 🧩 Esercizio 1 — con soluzione

**Obiettivo**: Trovare tutti i clienti (`customer`) del negozio 1 che si chiamano `MARY` **oppure** si chiamano `SMITH`.

### 🔹 Query corretta:

```sql
SELECT * FROM customer
WHERE store_id = 1 AND (first_name = 'MARY' OR last_name = 'SMITH');
```

### 🧠 Spiegazione:
- La parentesi serve per assicurarsi che MySQL valuti il `first_name = 'MARY' OR last_name = 'SMITH'` **prima** di applicare il `AND store_id = 1`.

---

## ✍️ Esercizio 2 — scrivi tu la query più adatta

**Obiettivo**: Elenca tutti i clienti (customer) che sono attivi (active = 1) e il cui nome è 'MARY' oppure il cui cognome è 'SMITH'.

## ✍️ Esercizio 3 — scrivi tu la query più adatta

**Obiettivo**: Seleziona tutti i film (film) che hanno rating PG oppure G, ma solo se la loro durata (length) è superiore a 90 minuti.



