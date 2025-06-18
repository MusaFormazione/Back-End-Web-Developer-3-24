# 🐘 Utilizzare una versione personalizzata di PHP in XAMPP tramite FastCGI

## 🎯 Obiettivo

Questo documento spiega come utilizzare una versione di PHP diversa da quella inclusa in XAMPP, **senza cambiare il server Apache**, grazie all'uso del **modulo FastCGI (`mod_fcgid`)**.

È particolarmente utile per:

- 🆙 Effettuare upgrade o downgrade di PHP (es. da PHP 7 a PHP 8 o viceversa)
- 🧪 Testare più versioni di PHP nello stesso ambiente
- 🔒 Mantenere separata l’installazione di XAMPP

---

## 💡 Perché usare FastCGI

Tradizionalmente, XAMPP integra PHP come modulo diretto (`php7apache2_4.dll`), creando un legame binario tra Apache e PHP.

Con FastCGI:

- Apache e PHP sono **disaccoppiati**
- PHP gira come **processo esterno** (`php-cgi.exe`)
- È possibile utilizzare qualsiasi versione di PHP
- Nessuna dipendenza da compatibilità tra DLL

---

## 📦 Requisiti

- Apache (incluso in XAMPP va bene)
- PHP (es. da [windows.php.net](https://windows.php.net))
- Il modulo **`mod_fcgid.so`** copiato manualmente nella cartella `modules` di Apache:

```
C:\xampp\apache\modules\mod_fcgid.so
```

> ⚠️ Download del modulo [mod_fcgid.so](mod_fcgid.so) (scaricare alternativamente da [apache lounge](https://www.apachelounge.com/))

---

## 🛠 Configurazione passo passo

### 1. 📂 Installa PHP in una cartella separata

Ad esempio:

```
C:\php
```

Contiene: `php-cgi.exe`, `php.ini`, `ext`, ecc.

---

### 2. 🧱 Crea file di configurazione Apache personalizzato

Percorso:

```
C:\xampp\apache\conf\extra\httpd-custom-cgi.conf
```

Contenuto:

```apache
LoadModule fcgid_module modules/mod_fcgid.so # -- Carica il modulo che consente ad apache di lavorare con fastCGI 

<IfModule fcgid_module> # Fornisci ad apache i riferimenti di PHP CGI da usare come handler per i file PHP
    AddHandler fcgid-script .php
    FcgidInitialEnv PHPRC "C:/php"
    FcgidWrapper "C:/php/php-cgi.exe" .php

    <FilesMatch \.php$>
        SetHandler fcgid-script
    </FilesMatch>
</IfModule>
```


### 3. 🧱 Configura i Virtualhost per fare in modo che essi usino i CGI configurati

### 🔧 Tabella delle opzioni `Options` in Apache

| Opzione         | Descrizione                                                                 |
|-----------------|-----------------------------------------------------------------------------|
| `None`          | Disabilita tutte le opzioni per la directory. È la configurazione più restrittiva. |
| `All`           | Abilita tutte le opzioni tranne `MultiViews`. (⚠️ sconsigliato se non necessario) |
| `Indexes`       | Se non c'è un file indice (es. `index.html`), Apache mostra l'elenco dei file. |
| `FollowSymLinks`| Permette ad Apache di seguire i **link simbolici** (es. `mklink /D`).       |
| `SymLinksIfOwnerMatch` | Come `FollowSymLinks`, ma Apache segue il link **solo se il proprietario è lo stesso**. |
| `Includes`      | Abilita **Server Side Includes (SSI)**. Richiede anche che `mod_include` sia attivo. |
| `IncludesNOEXEC`| Come `Includes`, ma **disabilita** l'esecuzione di comandi esterni nei file SSI. |
| `ExecCGI`       | Abilita l'esecuzione di script CGI, come `php-cgi.exe`, `perl`, ecc. Obbligatorio per usare PHP in FastCGI. |
| `MultiViews`    | Abilita il **content negotiation** per estensioni multiple (es. `pagina.en.html`, `pagina.it.html`) |
| `RunScripts`    | Alias per `ExecCGI` (raro, dipende da configurazioni legacy).               |

> ✅ Puoi combinare più opzioni con uno spazio, es:  
> `Options Indexes FollowSymLinks ExecCGI`


```apache

Alias /phpmyadmin "C:/xampp/phpMyAdmin/"
<Directory "C:/xampp/phpMyAdmin">
    Options Indexes FollowSymLinks Includes ExecCGI # Nota bene qui: ExecCGI abilita questo website ad usare i CGI
    AllowOverride All
    Require all granted
</Directory>

```

---

### 4. ✂️ Disattiva il blocco PHP di XAMPP

Modifica il file:

```
C:\xampp\apache\conf\httpd.conf
```

- **Commenta**:
  ```apache
  #Include "conf/extra/httpd-xampp.conf"
  ```

- **Aggiungi**:
  ```apache
  Include "conf/extra/httpd-custom-cgi.conf"
  ```

---

### 5. 🔧 Imposta la cartella delle sessioni in php.ini

Nel file `C:/php/php.ini`, assicurati di avere:

```ini
session.save_path = "C:/xampp/tmp"
```

Se la cartella non esiste, creala manualmente.

---

### 6. 🔁 Riavvia Apache

Puoi farlo dal pannello XAMPP oppure da terminale:

```
C:\xampp\apache\bin\httpd.exe
```

---

## ✅ Verifica funzionamento

Crea un file `info.php` in `C:/xampp/htdocs`:

```php
<?php phpinfo(); ?>
```

Visita:

```
http://localhost/info.php
```

Dovresti vedere la nuova versione di PHP in uso.

---

## 🧠 Vantaggi dell'approccio FastCGI

| Vantaggio         | Descrizione |
|-------------------|-------------|
| 🔗 Disaccoppiamento | PHP e Apache non dipendono più a livello binario |
| ♻️ Cambio rapido    | Basta sostituire la cartella PHP e riavviare Apache |
| 🔐 Maggiore stabilità | Nessun crash da DLL incompatibili |
| 🧪 Multi-versione   | Possibilità di usare più versioni PHP in parallelo |

---

## ℹ️ Note finali

Il modulo `mod_fcgid.so` deve essere **copiato manualmente** nella cartella `modules` di Apache. Questo progetto lo fornisce già compilato.
