# 🔍 Query di Base: Introduzione al DML (Data Manipulation Language)

Il Data Manipulation Language (DML) è un sottoinsieme del linguaggio SQL che permette di manipolare i dati all'interno delle tabelle di un database. Le operazioni principali del DML sono:

- **SELECT**: per recuperare dati
- **INSERT**: per inserire nuovi dati
- **UPDATE**: per modificare dati esistenti
- **DELETE**: per eliminare dati

Questo documento introduce le query di base del DML con esempi pratici utilizzando il database Sakila.

## 📋 SELECT: Recuperare Dati

La query SELECT è la più comune e permette di estrarre dati dalle tabelle.

### Sintassi di base:
```sql
SELECT colonna1, colonna2, ... FROM tabella;
```

### Esempi:

#### Selezionare tutte le colonne:
```sql
SELECT * FROM sakila.film;
```

#### Selezionare colonne specifiche:
```sql
SELECT title, release_year, rental_rate FROM sakila.film;
```

#### Filtrare con WHERE:
```sql
SELECT * FROM sakila.film WHERE rental_rate > 2.00;
```

#### Utilizzare LIKE per ricerche di testo:
```sql
-- Film che finiscono con 'A'
SELECT * FROM sakila.film WHERE title LIKE '%A';

-- Film che iniziano con 'A'
SELECT * FROM sakila.film WHERE title LIKE 'A%';

-- Film che contengono 'A'
SELECT * FROM sakila.film WHERE title LIKE '%A%';
```

#### Utilizzare operatori logici (AND, OR, NOT, XOR):

##### Tabelle della verità per gli operatori logici:

###### AND (E logico)
L'operatore AND restituisce TRUE solo se entrambe le condizioni sono TRUE.

| A | B | A AND B |
|---|---|---------|
| TRUE | TRUE | TRUE |
| TRUE | FALSE | FALSE |
| FALSE | TRUE | FALSE |
| FALSE | FALSE | FALSE |

###### OR (O logico)
L'operatore OR restituisce TRUE se almeno una delle condizioni è TRUE.

| A | B | A OR B |
|---|---|--------|
| TRUE | TRUE | TRUE |
| TRUE | FALSE | TRUE |
| FALSE | TRUE | TRUE |
| FALSE | FALSE | FALSE |

###### NOT (Negazione logica)
L'operatore NOT inverte il valore di verità di una condizione.

| A | NOT A |
|---|-------|
| TRUE | FALSE |
| FALSE | TRUE |

###### XOR (O esclusivo)
L'operatore XOR restituisce TRUE se esattamente una delle condizioni è TRUE.

| A | B | A XOR B |
|---|---|---------|
| TRUE | TRUE | FALSE |
| TRUE | FALSE | TRUE |
| FALSE | TRUE | TRUE |
| FALSE | FALSE | FALSE |

```sql
-- Film che contengono 'A' E hanno un prezzo di noleggio <= 2.00
SELECT * FROM sakila.film 
WHERE title LIKE '%A%' AND rental_rate <= 2.00;

-- Film che iniziano con 'A' OPPURE con 'B'
SELECT * FROM sakila.film 
WHERE title LIKE 'A%' OR title LIKE 'B%';

-- Esempio complesso con AND, OR e NOT
-- Film che contengono 'D', 'A' e 'X' e hanno un prezzo di noleggio <= 2.00
SELECT rental_rate FROM sakila.film WHERE 
title LIKE '%D%' AND title LIKE '%A%' AND title LIKE '%X%'
AND NOT rental_rate > 2.00;

-- Film che iniziano con 'D', 'A' o 'X'
SELECT * FROM sakila.film WHERE 
title LIKE 'D%' OR title LIKE 'A%' OR title LIKE 'X%';

-- Esempio con XOR (restituisce TRUE se esattamente una delle condizioni è TRUE)
SELECT * FROM sakila.film
WHERE (rental_rate > 2.00) XOR (length > 120);
```

#### Utilizzare parentesi per controllare la precedenza degli operatori:
```sql
-- Senza parentesi (OR ha precedenza inferiore rispetto ad AND)
SELECT count(*) FROM sakila.film WHERE 
title LIKE '%A%' OR title LIKE '%B%' AND rental_rate > 2.00;

-- Con parentesi (cambia la precedenza)
SELECT count(*) FROM sakila.film WHERE 
(title LIKE '%A%' OR title LIKE '%B%') AND rental_rate > 2.00;

-- Esempi più complessi con parentesi
SELECT count(*) FROM sakila.film WHERE 
title LIKE '%A%' AND rental_rate > 2.00 AND 
(film_id = '103' OR film_id = 150);

-- Combinazione di condizioni con diversa precedenza
SELECT count(*) FROM sakila.film WHERE 
title LIKE '%A%' AND rental_rate > 2.00 AND film_id = '103' -- prima condizione
OR 
film_id = 150; -- seconda condizione
```

#### Utilizzare IN e NOT IN per liste di valori:
```sql
-- Utilizzare IN con una lista di valori
SELECT * FROM sakila.film 
WHERE title IN ('ADAPTATION HOLES','AFFAIR PREJUDICE','AFRICAN EGG');

-- Confronto tra IN e OR (risultato equivalente)
SELECT * FROM sakila.film WHERE 
title = 'ADAPTATION HOLES' OR title = 'AFFAIR PREJUDICE' OR title = 'AFRICAN EGG';

-- Utilizzare NOT IN per escludere valori
SELECT * FROM sakila.film WHERE 
title NOT IN ('ADAPTATION HOLES','AFFAIR PREJUDICE','AFRICAN EGG');
```

#### Confronto tra stringhe e funzioni di stringa:
```sql
-- Confronto tra stringhe (film con titolo che viene prima di 'B' in ordine alfabetico)
SELECT film_id, title FROM sakila.film WHERE title < 'B';

-- Utilizzare SUBSTRING per estrarre parti di una stringa
SELECT SUBSTRING(title, 1, 2) FROM sakila.film;

-- Filtrare in base al risultato di SUBSTRING
SELECT film_id, title FROM sakila.film WHERE SUBSTRING(title, 1, 1) > 'B';
```

#### Ordinare i risultati con ORDER BY:
```sql
SELECT title, rental_rate FROM sakila.film 
ORDER BY rental_rate DESC, title ASC;
```

#### Limitare i risultati con LIMIT:
```sql
SELECT * FROM sakila.film LIMIT 10;
```

## ➕ INSERT: Inserire Dati

La query INSERT permette di aggiungere nuovi record alle tabelle.

### Sintassi di base:
```sql
INSERT INTO tabella (colonna1, colonna2, ...) VALUES (valore1, valore2, ...);
```

### Esempi:

#### Inserire un singolo record:
```sql
INSERT INTO sakila.film (title, language_id, rental_duration, rental_rate) 
VALUES ('Nuovo Film', 1, 3, 4.99);
```

#### Inserire più record contemporaneamente:
```sql
INSERT INTO sakila.film (title, language_id) 
VALUES ('Film Uno', 1), ('Film Due', 1), ('Film Tre', 1);
```

## 🔄 UPDATE: Modificare Dati

La query UPDATE permette di modificare dati esistenti nelle tabelle.

### Sintassi di base:
```sql
UPDATE tabella SET colonna1 = valore1, colonna2 = valore2 WHERE condizione;
```

### Esempi:

#### Aggiornare un singolo campo:
```sql
UPDATE sakila.film 
SET rental_rate = 3.99 
WHERE film_id = 1;
```

#### Aggiornare più campi contemporaneamente:
```sql
UPDATE sakila.film 
SET rental_rate = 4.99, rental_duration = 5 
WHERE rating = 'G';
```

⚠️ **Attenzione**: È importante utilizzare la clausola WHERE nelle query UPDATE per evitare di modificare tutti i record della tabella.

## ❌ DELETE: Eliminare Dati

La query DELETE permette di eliminare record dalle tabelle.

### Sintassi di base:
```sql
DELETE FROM tabella WHERE condizione;
```

### Esempi:

#### Eliminare record specifici:
```sql
DELETE FROM sakila.film 
WHERE film_id = 1;
```

#### Eliminare record in base a una condizione:
```sql
DELETE FROM sakila.film 
WHERE rental_rate < 1.00;
```

⚠️ **Attenzione**: È fondamentale utilizzare la clausola WHERE nelle query DELETE per evitare di eliminare tutti i record della tabella.

## 🗑️ TRUNCATE: Svuotare Tabelle

La query TRUNCATE permette di eliminare rapidamente tutti i record di una tabella, resettandola al suo stato iniziale.

### Sintassi di base:
```sql
TRUNCATE TABLE tabella;
```

### Esempi:

#### Svuotare completamente una tabella:
```sql
TRUNCATE TABLE sakila.rental_backup;
```

### Differenze tra TRUNCATE e DELETE:

| Caratteristica | TRUNCATE | DELETE |
|----------------|----------|--------|
| Velocità | Molto veloce (non registra ogni riga eliminata) | Più lento (registra ogni riga eliminata) |
| Clausola WHERE | Non supportata (elimina sempre tutte le righe) | Supportata (può eliminare righe selettive) |
| Log delle transazioni | Minimo (registra solo l'allocazione delle pagine) | Completo (registra ogni riga eliminata) |
| Auto-increment | Resetta i contatori di auto-increment | Non resetta i contatori di auto-increment |
| Trigger | Non attiva i trigger | Attiva i trigger DELETE |
| Rollback | Non può essere annullato con ROLLBACK | Può essere annullato con ROLLBACK |
| Permessi | Richiede permessi ALTER sulla tabella | Richiede permessi DELETE sulla tabella |

⚠️ **Attenzione**: TRUNCATE elimina TUTTI i dati dalla tabella senza possibilità di recupero. Utilizzare con estrema cautela.

## 🔍 Query Avanzate

Per query più complesse che coinvolgono JOIN, GROUP BY, HAVING, subquery e altro, consultare la documentazione sulle [Query Avanzate](../DML_EserciziQuery/README.MD).

## 🏗️ Creare e Popolare Tabelle

Oltre alle operazioni DML, è importante conoscere anche le operazioni DDL (Data Definition Language) per creare tabelle.

### Creare una nuova tabella:
```sql
CREATE TABLE PreferredTitles (
    title VARCHAR(100)
);
```

### Inserire dati in una tabella appena creata:
```sql
INSERT INTO PreferredTitles VALUES ('NON COMPRESO');
```

### Inserire più valori contemporaneamente:
```sql
INSERT INTO film (title, language_id) VALUES ('C.', 1), ('C0', 1);
```

## 📚 Risorse Aggiuntive

- [Operatori Booleani](../DML_OperatoriBooleani)
- [Limitare I Risultati (LIMIT)](../DML_LimitareRisultati)
- [Ordinamento Con ORDER BY](../DML_OrderBy)
- [Join Tra Tabelle](../DML_JOIN)
