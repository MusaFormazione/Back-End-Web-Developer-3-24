## SQL Modes
## Demo sull'utilizzo dei SQL Modes
### Obiettivo: Comprendere come funzionano i SQL Modes


### Sperimentazione modificando il comportamento con STRICT_ALL_TABLES,NO_ZERO_DATE

```sql
SELECT @@sql_mode;
```

Creiamo una semplice tabella:
```sql
CREATE DATABASE IF NOT EXISTS test_sql_modes_db;
USE test_sql_modes_db;
```
```sql
DROP TABLE IF EXISTS test_sqlmode;
CREATE TABLE test_sqlmode (
id INT,
data_di_nascita DATE
);
```
### Test permissivo (senza strict mode)

```sql 
SET SESSION sql_mode = '';

-- Inserisce 'abc' in INT → accetta e mette 0
INSERT INTO test_sqlmode VALUES ('abc', '2020-01-01');

-- Inserisce '0000-00-00' → accetta come data
INSERT INTO test_sqlmode VALUES (2, '0000-00-00');

SELECT * FROM test_sqlmode; # verifichiamo i dati
```


### Attiva modalità severa

```sql 
SET SESSION sql_mode = 'STRICT_ALL_TABLES,NO_ZERO_DATE';

-- Errore: 'abc' non può essere convertito in INT
INSERT INTO test_sqlmode VALUES ('abc', '2020-01-01');

-- Errore: '0000-00-00' è vietata
INSERT INTO test_sqlmode VALUES (3, '0000-00-00');
```

### Resetta a come era prima (opzionale)

```sql
SET SESSION sql_mode = @@GLOBAL.sql_mode;
```