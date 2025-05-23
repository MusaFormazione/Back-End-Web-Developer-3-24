
# ✂️ MySQL `DELIMITER` - A Cosa Serve e Quando Usarlo

## 📌 Cos'è `DELIMITER`

In MySQL, il comando `DELIMITER` **non fa parte del linguaggio SQL**, ma è un'istruzione per il client (come il terminale o MySQL Workbench) per **cambiare temporaneamente il simbolo di fine istruzione**.

### 🧠 Perché è utile?

Quando scrivi **Stored Procedure**, **Function** o **Trigger**, il codice include **più comandi SQL separati da `;`**. Se non cambi il delimitatore, il client MySQL pensa che la tua istruzione sia finita **al primo `;`** e quindi genera errore.

---

## ✅ Esempio con `DELIMITER`

```sql
DELIMITER $$

CREATE PROCEDURE esempio()
BEGIN
   SELECT NOW();
   SELECT 'ok';
END $$

DELIMITER ;
```

- `DELIMITER $$`: cambia il simbolo di fine da `;` a `$$`
- `END $$`: fine della procedura
- `DELIMITER ;`: ripristina il comportamento normale

---

## 🔍 Quando Serve

✅ Serve quando:
- Scrivi **procedure**, **funzioni** o **trigger** nel terminale MySQL
- Usi MySQL Workbench

❌ Non serve quando:
- Esegui script `.sql` da strumenti che gestiscono i blocchi automaticamente (es. alcuni pannelli admin o PHPMyAdmin)
- Stai eseguendo singole query normali (`SELECT`, `INSERT`, ecc.)

---

## 🧪 Esercizio

Scrivi una **stored procedure** che restituisce `NOW()` e una stringa qualsiasi. Prova a eseguirla **senza `DELIMITER`** e verifica l’errore. Poi riprova **con `DELIMITER`**.

---

Corso: **Backend Web Development**  
Trainer: **Antonio Bruno**
