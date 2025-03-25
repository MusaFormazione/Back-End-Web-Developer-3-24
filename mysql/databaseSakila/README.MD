# Presentazione della Cartella

Questa cartella contiene script SQL utili per il ripristino di due database: uno compatibile con MySQL Standard, e
l'altro progettato per MariaDB. Qui di seguito troverai le istruzioni di base su come ripristinare i database
utilizzando entrambi i sistemi.

---

## Contenuto della Cartella

- **`database_mysql.sql`**: File di dump del database per MySQL Standard.
- **`database_mariadb.sql`**: File di dump del database per MariaDB.

---

## Istruzioni per il Ripristino

### Usando MySQL Standard

1. Apri una shell del terminale (o il prompt dei comandi) e assicurati che `mysql` sia configurato nel tuo `PATH` o
   fornisci il percorso completo.
2. Esegui il comando per caricare il dump nel database desiderato:

```bash
mysql -u NOME_UTENTE -p NOME_DATABASE < percorso/del/file/database_mysql.sql
```

Sostituisci:

- `NOME_UTENTE` con il nome utente del tuo account MySQL.
- `NOME_DATABASE` con il nome del database che desideri ripristinare (deve già esistere).
- `percorso/del/file/database_mysql.sql` con il percorso completo del file di dump.

3. Inserisci la password quando richiesta.

---

### Usando MariaDB

1. Analogamente a quanto fatto con MySQL, apri una shell del terminale e utilizza il comando appropriato per
   ripristinare il database usando MariaDB:

```bash
mariadb -u NOME_UTENTE -p NOME_DATABASE < percorso/del/file/database_mariadb.sql
```

In alternativa, se non hai il comando `mariadb` installato, puoi utilizzare `mysql` con MariaDB:

```bash
mysql -u NOME_UTENTE -p NOME_DATABASE < percorso/del/file/database_mariadb.sql
```

Sostituisci:

- `NOME_UTENTE` con l'utente MariaDB configurato.
- `NOME_DATABASE` con il database da ripristinare (deve già essere presente).
- `percorso/del/file/database_mariadb.sql` con il percorso completo del file di dump.

---

## Note Importanti

- Assicurati che il servizio MySQL o MariaDB sia in esecuzione sul tuo sistema prima di lanciare i comandi.
- Se il database di destinazione non esiste già, deve essere creato manualmente prima del ripristino con il seguente
  comando:

```sql
CREATE DATABASE NOME_DATABASE;
```

---

## Risoluzione dei Problemi

- **Errore "Access Denied"**: Controlla che il nome utente e la password siano corretti.
- **Errore "Database does not exist"**: Assicurati di aver creato il database prima di tentare il ripristino.

---