# Presentazione della Cartella

Questa cartella contiene script SQL utili per il ripristino del database Sakila, in 2 versione: una compatibile con MySQL Standard, e
l'altra progettato per MariaDB. Qui di seguito troverai le istruzioni di base su come ripristinare i database
utilizzando entrambi i sistemi.

## Cos'è il database Sakila?

Il database Sakila è un database di esempio fornito da MySQL, progettato per illustrare le funzionalità e le
potenzialità del sistema di gestione MySQL. È un database relazionale che rappresenta uno scenario di business reale: un
sistema di gestione per un negozio di noleggio video.

Il database contiene dati realistici e una struttura complessa progettata per dimostrare l'uso di funzionalità comuni
come:

- **Tabelle relazionali**: Rappresentano concetti come inventario, clienti, noleggi e pagamenti.
- **Chiavi esterne e indici**: Dimostrano le relazioni tra le tabelle e migliorano le prestazioni.
- **Query e viste**: Utilizzate per illustrare l'interrogazione e la strutturazione dei dati.
- **Stored Procedures e Trigger**: Mostrano come il database può implementare logiche lato server.

Sakila è ampiamente utilizzato come strumento educativo e di sviluppo per apprendere e testare funzionalità avanzate del
database.

---

## Contenuto della Cartella

- **`SAKILA_MYSQL_DUMP.sql`**: File di dump del database per MySQL Standard.
- **`SAKILA_MARIADB_DUMP.sql`**: File di dump del database per MariaDB.

---

## Istruzioni per il Ripristino

### Usando MySQL Standard

1. Apri una shell del terminale (o il prompt dei comandi) e assicurati che `mysql` sia configurato nel tuo `PATH` o
   fornisci il percorso completo.
2. Esegui il comando per caricare il dump nel database desiderato:

```bash
mysql -u NOME_UTENTE -p NOME_DATABASE < percorso/del/file/SAKILA_MYSQL_DUMP.sql
```

Sostituisci:

- `NOME_UTENTE` con il nome utente del tuo account MySQL.
- `NOME_DATABASE` con il nome del database che desideri ripristinare (deve già esistere).
- `percorso/del/file/SAKILA_MYSQL_DUMP.sql` con il percorso completo del file di dump.

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
mysql -u NOME_UTENTE -p NOME_DATABASE < percorso/del/file/SAKILA_MARIADB_DUMP.sql
```

Sostituisci:

- `NOME_UTENTE` con l'utente MariaDB configurato.
- `NOME_DATABASE` con il database da ripristinare (deve già essere presente).
- `percorso/del/file/SAKILA_MARIADB_DUMP.sql` con il percorso completo del file di dump.

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