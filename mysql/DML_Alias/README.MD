
# 🏷️ Alias in SQL (`AS`)

## ✅ Cos'è un alias

Un alias è un **nome temporaneo** assegnato a una colonna o a una tabella per rendere i risultati **più leggibili** o per facilitare la scrittura della query.

---

## 🔹 Alias per colonne

```sql
SELECT first_name AS nome, last_name AS cognome
FROM customer;
```

- `AS` è opzionale, ma migliora la leggibilità.

```sql
SELECT first_name nome, last_name cognome
FROM customer;
```

---

## 🔹 Alias per tabelle

Utile soprattutto con le `JOIN`.

```sql
SELECT c.first_name, p.amount
FROM customer AS c
JOIN payment AS p ON c.customer_id = p.customer_id;
```

---

# 🧪 Esercizi su Alias

## 🔹 Esercizio 1 — da svolgere insieme

**Obiettivo**: Mostra i clienti (`customer`) visualizzando `first_name` e `last_name` come un campo unico chiamato `full_name`.

```sql
SELECT CONCAT(first_name, ' ', last_name) AS full_name
FROM customer;
```

---

## ✍️ Esercizio 2 — scrivi tu la soluzione

**Obiettivo**: Mostra tutti i film (`film`) con un alias per `title` chiamato `titolo` e per `length` chiamato `durata_minuti`.

```sql
-- Suggerimento: usa AS per entrambe le colonne
```

---

## ✍️ Esercizio 3 — scrivi tu la soluzione

**Obiettivo**: Conta il numero di clienti per store e assegna alla colonna aggregata l’alias `totale_clienti`.

```sql
-- Suggerimento: COUNT(*) AS totale_clienti
```
