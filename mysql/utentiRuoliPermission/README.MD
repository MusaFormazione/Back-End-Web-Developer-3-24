## 👤 Utente: `'antonio'@'localhost'`
## 🎭 Ruolo: `lettore_sakila`
### 🎯 Obiettivo: concedere all'utente permessi di sola lettura sulla tabella `sakila.actor`

---

### 1. Creazione del ruolo

```sql
CREATE ROLE lettore_sakila;
```

### 2. Assegnazione dei privilegi al ruolo

```sql
GRANT SELECT ON sakila.actor TO lettore_sakila;
```

### 3. Assegnazione del ruolo all’utente

```sql
GRANT lettore_sakila TO 'antonio'@'localhost';
```

### 4. L'utente può assumere un ruolo (creato e assegnato da un amministratore)

```sql
SET <ruolo1>, <ruolo2>, ... ;
```

### 5. Attivazione automatica del ruolo al login

```sql
SET DEFAULT ROLE lettore_sakila TO 'antonio'@'localhost';
```

### 6. Revocare un ruolo
```sql
REVOKE <ruolo1>, <ruolo2>, ... FROM 'utente'@'host';
```

### 7. Verifica

```sql
SHOW GRANTS FOR 'user1'@'localhost';
SELECT CURRENT_ROLE(); -- da eseguire come user1
```