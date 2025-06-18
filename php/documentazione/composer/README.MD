# Esempio di Progetto Composer

Questo progetto dimostra l'utilizzo di Composer per la gestione delle dipendenze in PHP.

## Tutorial di Riferimento

Per imparare ad usare Composer, abbiamo seguito il tutorial disponibile alla pagina [https://phpunit.de/getting-started/phpunit-9.html](https://phpunit.de/getting-started/phpunit-9.html). Questo tutorial ci ha guidato attraverso i passaggi fondamentali per configurare un progetto PHP con Composer e PHPUnit.

## Struttura del Progetto

- `src/`: Contiene il codice sorgente del progetto
  - `Email.php`: Classe per la validazione e gestione degli indirizzi email
- `tests/`: Contiene i test unitari
  - `EmailTest.php`: Test per la classe Email
- `vendor/`: La Directory generata da Composer contenente le dipendenze
- `composer.json`: File di configurazione di Composer
- `composer.lock`: File di lock delle dipendenze

## Configurazione Composer

### Dipendenze
Nel file `composer.json`, le dipendenze del progetto sono definite nella sezione `require-dev`:

```json
{ 
  "require-dev": { 
    "phpunit/phpunit": "^12.2"
  }
}

```
### Autoloading
Il progetto dimostra due approcci diversi per la configurazione dell'autoloading:

1. **Approccio PSR-4** (configurazione attuale)

```json
 { 
  "autoload": { 
    "psr-4": {
      "Musa\\BackendWebDevelopment\\" : "src/"
    }
  } 
}
```
Questo approccio segue lo standard PSR-4, mappando i namespace alle directory corrispondenti. Le classi nella directory `src/` sono caricate sotto il namespace `Composer\Sample\`, mentre i test sotto il namespace `tests\`.

2. **Approccio Classmap** (configurazione alternativa)

```json
 { 
  "autoload": {
    "classmap": [
      "src/"
    ]
  } 
}
```
Questo approccio alternativo, mostrato nel `composer-backup.json`, utilizza il classmap che scansiona automaticamente la directory specificata e crea una mappa di tutte le classi trovate. È più semplice da configurare ma meno strutturato rispetto all'approccio PSR-4.

Dopo qualsiasi modifica alla configurazione dell'autoloading, è necessario rigenerare l'autoloader con:

```bash
composer dump-autoload
```

## Requisiti

- PHP 8.0 o superiore
- Composer

## Installazione

1. Clona il repository
2. Esegui `composer install` per installare le dipendenze

```bash
git clone <url-repository>
cd composer_sample_live
composer install
```

## Autoloading

Il progetto utilizza l'autoloading PSR-4 di Composer con il namespace `Musa\BackendWebDevelopment` che punta alla directory `src/`.
