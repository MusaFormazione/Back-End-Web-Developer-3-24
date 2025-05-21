
# 👁️ Le Viste (VIEW) in MySQL

Le **VIEW** (viste) in MySQL sono oggetti virtuali che rappresentano il risultato di una `SELECT`. Sono utili per semplificare query complesse, proteggere i dati sensibili o creare una base dati personalizzata per utenti e applicazioni.

---

## 🧱 Creazione di una Vista

```sql
CREATE VIEW elenco_film AS
SELECT film_id, title, rental_rate, rating
FROM film
WHERE rating = 'PG';
```

Questa vista rappresenta tutti i film con classificazione PG.

---

## 👀 Utilizzo di una Vista

Una vista si utilizza come una normale tabella:

```sql
SELECT * FROM elenco_film;
```

Puoi anche filtrare o ordinare:

```sql
SELECT title, rental_rate
FROM elenco_film
WHERE rental_rate < 3
ORDER BY title;
```

---

## 🔄 Aggiornare una Vista

```sql
ALTER VIEW elenco_film AS
SELECT film_id, title, rental_rate
FROM film
WHERE rental_rate < 4;
```

> ⚠️ `ALTER` sovrascrive la vista se esiste già.

---

## ❌ Eliminare una Vista

```sql
DROP VIEW elenco_film;
```

---

## 📌 Limitazioni

- Alcune viste **non sono aggiornabili**, ad esempio se contengono `GROUP BY`, `DISTINCT`, `UNION`, `LIMIT`.
- Le viste **non memorizzano i dati**, ma solo la query.

---

## 🧪 Esercizi

### Esercizio 1
Crea una vista chiamata `clienti_attivi` che contenga `first_name`, `last_name` e `email` dei clienti con `active = 1`.

### Esercizio 2
Crea una vista `film_economici` con `title`, `rental_rate` e `replacement_cost` dei film con `rental_rate < 3`.

### Esercizio 3
Prova a usare una vista per unire `film` e `language` per ottenere `title` e `language.name`.

---

Corso: **Backend Web Development**  
Trainer: **Antonio Bruno**
