# Esercitazione Docker Compose

Questo progetto è un'esercitazione sull'utilizzo di Docker Compose per gestire applicazioni multi-container, con particolare attenzione alla configurazione e comunicazione tra servizi.

## Struttura del Progetto

- `Dockerfile`: Contiene le istruzioni per costruire l'immagine Docker per i servizi web
- `docker-compose.yml`: File di configurazione per Docker Compose che definisce i servizi
- `index.php`: Un semplice file PHP che dimostra la comunicazione tra servizi

## Il Dockerfile

Il Dockerfile utilizza l'immagine ufficiale PHP 8.4 con Apache come base e configura un ambiente per eseguire applicazioni PHP con supporto MySQL:

```dockerfile
FROM php:8.4-apache

RUN chown -R www-data:www-data /var/www/html

RUN echo "ServerName docker-php-server" >> "/etc/apache2/apache2.conf"

RUN docker-php-ext-install pdo pdo_mysql mysqli

RUN docker-php-ext-enable pdo_mysql mysqli

EXPOSE 80

CMD ["apache2-foreground"]
```

- `FROM php:8.4-apache`: Utilizza l'immagine ufficiale PHP 8.4 con Apache
- `RUN chown -R www-data:www-data /var/www/html`: Imposta i permessi corretti per la directory web
- `RUN echo "ServerName docker-php-server" >> "/etc/apache2/apache2.conf"`: Configura il nome del server Apache
- `RUN docker-php-ext-install pdo pdo_mysql mysqli`: Installa le estensioni PHP per MySQL
- `RUN docker-php-ext-enable pdo_mysql mysqli`: Abilita le estensioni PHP per MySQL
- `EXPOSE 80`: Espone la porta 80 per il traffico web
- `CMD ["apache2-foreground"]`: Esegue Apache in primo piano

## Docker Compose

Il file `docker-compose.yml` definisce tre servizi:

```yaml
version: '3.8'
services:
  check-from-compose:
    build: .
    ports:
      - "80:80"
    volumes:
      - "./:/var/www/html"
  second-stuff:
    build: .
    ports:
      - "85:80"
    volumes:
      - "./:/var/www/html"
  database:
    image: "mysql/mysql"
```

- `version: '3.8'`: Specifica la versione di Docker Compose
- `services`: Definisce i servizi da eseguire
  - `check-from-compose`: Primo servizio web
    - `build: .`: Costruisce l'immagine usando il Dockerfile nella directory corrente
    - `ports: - "80:80"`: Mappa la porta 80 del host alla porta 80 del container
    - `volumes: - "./:/var/www/html"`: Monta la directory corrente in `/var/www/html` nel container
  - `second-stuff`: Secondo servizio web (clone del primo ma su porta diversa)
    - `ports: - "85:80"`: Mappa la porta 85 del host alla porta 80 del container
  - `database`: Servizio database
    - `image: "mysql/mysql"`: Utilizza l'immagine MySQL ufficiale

## Comunicazione tra Servizi

L'applicazione dimostra come i servizi possono comunicare tra loro in un ambiente Docker Compose:

1. Per comunicare con un altro servizio, si utilizza il nome del servizio e la porta, ad esempio:
   ```
   database:3306
   ```

2. Per comunicare con un servizio sull'host dal container, si utilizza:
   ```
   host.docker.internal:3306
   ```

## Comandi Docker Compose

### Avviare i servizi

Per avviare tutti i servizi definiti nel file `docker-compose.yml`:

```bash
docker-compose up
```

Per avviare i servizi in background:

```bash
docker-compose up -d
```

### Costruire le immagini

Per costruire o ricostruire le immagini:

```bash
docker-compose build
```

### Fermare i servizi

Per fermare i servizi:

```bash
docker-compose down
```

Per fermare i servizi e rimuovere i volumi:

```bash
docker-compose down -v
```

### Visualizzare i log

Per visualizzare i log di tutti i servizi:

```bash
docker-compose logs
```

Per visualizzare i log di un servizio specifico:

```bash
docker-compose logs [nome-servizio]
```

### Eseguire comandi in un container

Per eseguire un comando in un container in esecuzione:

```bash
docker-compose exec [nome-servizio] [comando]
```

Esempio:
```bash
docker-compose exec check-from-compose php -v
```

## Accedere all'applicazione

Dopo aver avviato i servizi, puoi accedere all'applicazione nel tuo browser web agli indirizzi:

- Primo servizio: `http://localhost:80`
- Secondo servizio: `http://localhost:85`

## Vantaggi di Docker Compose

Docker Compose offre numerosi vantaggi rispetto all'utilizzo di Docker da solo:

1. **Gestione semplificata di applicazioni multi-container**: Definisci tutti i servizi in un unico file
2. **Ambiente di sviluppo isolato**: Ogni sviluppatore può avere lo stesso ambiente
3. **Facile scalabilità**: Puoi facilmente aggiungere o rimuovere servizi
4. **Configurazione dichiarativa**: La configurazione è descritta in un file YAML
5. **Gestione delle dipendenze**: I servizi possono dipendere l'uno dall'altro
6. **Networking automatico**: I servizi possono comunicare tra loro usando i nomi dei servizi
