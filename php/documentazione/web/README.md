# PHP Web Application with Docker

Questo progetto dimostra l'utilizzo di PHP con Docker per implementare funzionalità web comuni come gestione di richieste GET/POST, upload di file, sessioni, cookies e interazione con database MySQL.

## Panoramica del Progetto

Il progetto è una semplice applicazione web PHP che utilizza il database Sakila (un database di esempio di MySQL) per mostrare come:

- Gestire richieste GET e POST in PHP
- Processare upload di file
- Utilizzare sessioni e cookies
- Connettersi e interagire con un database MySQL
- Implementare operazioni CRUD (Create, Read, Update, Delete)

L'applicazione è containerizzata utilizzando Docker e Docker Compose per facilitare la configurazione dell'ambiente di sviluppo.

## Struttura del Progetto

```
web-e-db/
├── .idea/                  # Configurazione IDE
├── tmp/                    # Directory temporanea per PHP
│   ├── php/                # File temporanei PHP
│   └── sessions/           # File di sessione PHP
├── uploads/                # Directory per i file caricati
├── .gitignore              # File di configurazione Git
├── actors.php              # Visualizzazione e gestione attori
├── check.php               # Demo di GET, POST e upload file
├── config.inc.php          # Configurazione database
├── db_connection.php       # Classe per connessione database
├── docker-compose.yml      # Configurazione Docker Compose
├── Dockerfile              # Configurazione Docker
├── edit_actor.php          # Modifica dati attori
├── index.php               # Pagina principale
├── info.php                # Informazioni PHP
├── style.css               # Stili CSS
└── test_connection.php     # Test connessione database
```

## Funzionalità Principali

1. **Gestione GET/POST**: Dimostrata in `check.php` con form che utilizzano entrambi i metodi
2. **Upload File**: Implementato in `check.php` con gestione dei file caricati
3. **Sessioni**: Utilizzate in `actors.php` e `edit_actor.php` per messaggi di successo/errore
4. **Database**: Connessione PDO al database Sakila in `db_connection.php`
5. **CRUD Operations**: Visualizzazione e modifica dei dati degli attori

## Requisiti

- Docker
- Docker Compose

## Come Utilizzare

### Avvio dell'Applicazione

1. Clona il repository
2. Naviga nella directory del progetto
3. Avvia i container con Docker Compose:

```bash
docker-compose up -d
```

4. Accedi all'applicazione nel browser all'indirizzo: `http://localhost`

### Configurazione Database

Per connettere l'applicazione a un database MySQL, modifica il file `config.inc.php` con i parametri di connessione appropriati:

- Per un database in un altro container: usa `database:3306` come host
- Per un database sulla macchina host: usa `host.docker.internal:3306` (come configurato nel progetto)

*Attenzione alla porta... La porta standard è la 3306, ma voi potreste avere esposto il db su un'altra porta*.

### Esempi di Utilizzo

1. **Visualizzazione Attori**: Naviga su `http://localhost/actors.php`
2. **Modifica Attori**: Clicca su "Edit" accanto a un attore
3. **Test Form GET/POST**: Naviga su `http://localhost/check.php`
4. **Upload File**: Usa il form in `check.php` per caricare un file
5. **Test Connessione Database**: Naviga su `http://localhost/test_connection.php` per verificare la connessione al database

## Dettagli Tecnici

### Docker

L'applicazione utilizza:
- PHP 8.4 con Apache
- Estensioni PHP per MySQL (pdo_mysql, mysqli)
- Directory personalizzate per file temporanei e sessioni

### Connessione Database

La connessione al database è implementata utilizzando PDO (PHP Data Objects) per una maggiore sicurezza e flessibilità. Le query utilizzano prepared statements per prevenire SQL injection.

### Gestione Sessioni

Le sessioni sono configurate per essere salvate nella directory `/var/www/session-tmp` all'interno del container, mappata alla directory locale `./tmp/sessions`.

## Sviluppo Futuro

Possibili miglioramenti:
- Aggiungere autenticazione utenti
- Implementare funzionalità CRUD complete (aggiunta e cancellazione attori)
- Migliorare la sicurezza con validazione input più robusta
- Aggiungere test automatizzati

---

Questo progetto è stato creato a scopo didattico per illustrare concetti fondamentali di sviluppo web con PHP e Docker, pertanto non è da considerarsi completo, ma presenta per lo più piccoli esempi che mostrano come utilizzare PHP, con GET/POST, Sessioni, Cookie e DB.