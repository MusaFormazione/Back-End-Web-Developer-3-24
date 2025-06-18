# Esercitazione Docker

Questo progetto è un'esercitazione per la creazione di un Dockerfile e l'utilizzo di Docker per eseguire un'applicazione PHP semplice.

## Struttura del Progetto

- `Dockerfile`: Contiene le istruzioni per costruire l'immagine Docker
- `index.php`: Un semplice file PHP che mostra "Hello World from Docker!"

## Il Dockerfile

Il Dockerfile utilizza l'immagine ufficiale PHP 8.4 con Apache come base e configura un ambiente di base per eseguire applicazioni PHP:

```dockerfile
FROM php:8.4-apache

RUN chown -R www-data:www-data /var/www/html

EXPOSE 80

CMD ["apache2-foreground"]
```

- `FROM php:8.4-apache`: Utilizza l'immagine ufficiale PHP 8.4 con Apache
- `RUN chown -R www-data:www-data /var/www/html`: Imposta i permessi corretti per la directory web
- `EXPOSE 80`: Espone la porta 80 per il traffico web
- `CMD ["apache2-foreground"]`: Esegue Apache in primo piano

## Comandi Docker

### Costruire l'immagine Docker

Per costruire l'immagine Docker, esegui il seguente comando dalla directory che contiene il Dockerfile:

```bash
docker build -t php-hello-world .
```

Questo comando costruisce un'immagine Docker con il tag `php-hello-world` utilizzando il Dockerfile nella directory corrente.

### Eseguire il container

Per eseguire il container, utilizza il seguente comando:

```bash
docker run -p 8080:80 -v .:/var/www/html php-hello-world
```

Questo comando:
- Mappa la porta 8080 del tuo computer alla porta 80 del container
- Monta la directory corrente come volume in `/var/www/html` nel container
- Utilizza l'immagine `php-hello-world` creata in precedenza

### Accedere all'applicazione

Dopo aver avviato il container, puoi accedere all'applicazione nel tuo browser web all'indirizzo:

```
http://localhost:8080
```

Dovresti vedere il messaggio "Hello World from Docker!".

## Altri comandi Docker utili

### Visualizzare i container in esecuzione

```bash
docker ps
```

### Fermare un container

```bash
docker stop <container_id>
```

### Rimuovere un container

```bash
docker rm <container_id>
```

### Visualizzare le immagini Docker

```bash
docker images
```

### Rimuovere un'immagine Docker

```bash
docker rmi <image_id>
```
