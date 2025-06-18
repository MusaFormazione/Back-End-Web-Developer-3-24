# 🌐 Creare un Virtual Host con Apache in ambiente XAMPP

## 🎯 Obiettivo

Imparare cos'è un **Virtual Host** in Apache e come configurarne uno per creare siti locali personalizzati (es. `http://miosito.local`) in un ambiente XAMPP.

---

## ❓ Cos'è un Virtual Host

Un **Virtual Host** è una configurazione che permette ad Apache di servire **più siti web differenti sullo stesso server**, ognuno con:
- un nome (es. `miosito.local`)
- una cartella (DocumentRoot) separata
- regole di accesso e permessi propri

È uno strumento fondamentale per simulare ambienti reali in locale.

---

## 🧱 Requisiti

- Apache installato tramite XAMPP
- Il modulo `mod_fcgid.so` abilitato (vedi README precedente)
- Una versione di PHP Thread Safe installata in `C:/php`
- Aver già configurato FastCGI a livello globale (in `httpd-custom-cgi.conf`)

---

## ⚙️ Passaggi per creare un VirtualHost

### 1. Abilita i VirtualHost in Apache

Apri il file:

```
C:/xampp/apache/conf/httpd.conf
```

Sblocca questa riga:

```apache
Include conf/extra/httpd-vhosts.conf
```

---

### 2. Crea la cartella del sito

Esempio:

```
C:/dev/miosito
```

All'interno crea un file `index.php`:

```php
<?php echo "<h1>Benvenuto nel mio sito locale!</h1>"; ?>
```

---

### 3. Aggiungi il VirtualHost

Apri il file:

```
C:/xampp/apache/conf/extra/httpd-vhosts.conf
```

Aggiungi in fondo:

```apache
<VirtualHost *:80>
    ServerName miosito.local
    DocumentRoot "C:/dev/miosito"

    <Directory "C:/dev/miosito">
        Options Indexes FollowSymLinks ExecCGI
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

> Non serve configurare FastCGI qui, se lo hai già fatto globalmente.

---

### 4. Modifica il file `hosts`

Apri il file:

```
C:/Windows/System32/drivers/etc/hosts
```

Aggiungi in fondo:

```
127.0.0.1 miosito.local
```

> Questo permette al browser di risolvere `miosito.local` verso `localhost`.

---

### 5. Riavvia Apache

Usa il pannello di controllo XAMPP oppure esegui:

```
C:/xampp/apache/bin/httpd.exe
```

---

### 6. Testa nel browser

Visita:

```
http://miosito.local
```

Dovresti vedere il contenuto del tuo `index.php`.

---

## ✅ In sintesi

| Componente         | Funzione                                      |
|--------------------|-----------------------------------------------|
| `DocumentRoot`     | Cartella locale del sito                      |
| `ServerName`       | Nome locale usato nel browser (`.local`)      |
| `hosts` file       | Fa puntare `miosito.local` a `127.0.0.1`      |
| `httpd-vhosts.conf`| Configura Apache per gestire il sito          |

---

## 🧪 Esercizio

Crea un tuo sito locale personalizzato chiamato:

```
http://<tuo-nome>.local
```

Esempi:

- `http://marta.local`
- `http://luca.local`

Struttura:

- La cartella sarà `C:/dev/<tuo-nome>-site`
- Inserisci un file `index.php` che mostra una frase personalizzata

👉 Testa tutto nel browser e verifica che il sito sia raggiungibile in locale.

---
