# Configurazione di phpMyAdmin per MySQL Community Edition su macOS

Questo documento descrive la procedura per configurare il file di configurazione di phpMyAdmin in modo che funzioni con
MySQL Community Edition installato separatamente su un Mac.
Per default la versione di phpMyAdmin installata con xampp si connette al database utilizzando un socket UNIX...

```
Un socket UNIX è un file speciale che consente a due processi locali (sulla stessa macchina) di comunicare tra loro.
È una forma di comunicazione inter-processo (IPC), molto veloce e sicura, usata tantissimo da database come MySQL, PostgreSQL, Redis, ecc., quando client e server stanno sulla stessa macchina.
```

Ma dal momento che si desidera, eventualmente, far comunicare phpMyAdmin con un mysql installato separatamente, è necessario forzarlo a lavorare via ``TCP-IP``.
Da qui la modifica di impostare come host `IP` della macchina invece di localhost.

## 1. Localizzazione del file di configurazione di phpMyAdmin

Il file di configurazione di phpMyAdmin si chiama `config.inc.php` ed è solitamente situato nella directory principale
dell'installazione di phpMyAdmin. 

Nel caso di modifiche si intenda modificare il phpMyAdmin fornito con xampp, il percorso al file sarà

```bash
/applications/xampp/xamppfiles/phpmyadmin/config.inc.php
```

Se il file `config.inc.php` non esiste, potrebbe essere necessario duplicare e rinominare il file
`config.sample.inc.php` nella stessa directory.

## 2. Modifica del file `config.inc.php`

Dopo aver individuato il file `config.inc.php`, aprilo con un editor di testo.

All'interno del file di configurazione, identifica la sezione che definisce i parametri della connessione al database
MySQL.

Modifica o aggiungi i seguenti parametri per configurare phpMyAdmin in modo che lavori con MySQL Community Edition:

```php
/* Configurazione dei parametri della connessione */
$cfg['Servers'][$i]['host'] = '127.0.0.1'; // Indirizzo del server MySQL
$cfg['Servers'][$i]['port'] = '3306';      // Porta predefinita di MySQL (modifica se hai configurato una porta personalizzata)
$cfg['Servers'][$i]['user'] = 'root';      // Utente di MySQL con privilegi di amministrazione
$cfg['Servers'][$i]['password'] = '';      // Inserisci la password per l'utente root
$cfg['Servers'][$i]['AllowNoPassword'] = false; // Impedisce l'accesso senza password (consigliato)
```

## 3. Verifica dei permessi e del funzionamento

Dopo aver aggiornato il file di configurazione:

1. Assicurati che i permessi del file siano corretti per impedire accessi non autorizzati:
   ```bash
   chmod 660 /percorso/del/file/config.inc.php
   ```

2. Assicurati che phpMyAdmin sia puntato alla configurazione corretta ed effettua un accesso tramite browser per
   verificare che la connessione al server MySQL funzioni. Vai su:
   ```
   http://localhost/phpmyadmin
   ```

## 4. Risoluzione dei Problemi

- **Errore: Connection refused**  
  Verifica che il server MySQL sia in esecuzione e che l'host e la porta specificati siano corretti.

- **Errore: Access denied for user 'root'@'localhost'**  
  Controlla che il nome utente e la password configurati in `config.inc.php` siano corretti e che l'utente abbia i
  privilegi necessari.

- **Errore relativo al socket**  
  Modifica il parametro `$cfg['Servers'][$i]['socket']`, impostandolo al percorso corretto del socket di MySQL.

## 5. Conclusione

Seguendo i passi descritti, phpMyAdmin dovrebbe ora essere correttamente configurato per lavorare con MySQL Community
Edition su macOS. Se incontri altri problemi, consulta la documentazione ufficiale:

- [phpMyAdmin Documentation](https://docs.phpmyadmin.net/)
- [MySQL Documentation](https://dev.mysql.com/doc/)