
# 🔁 Trigger in MySQL

I trigger sono azioni automatiche eseguite in risposta a modifiche su tabelle (`INSERT`, `UPDATE`, `DELETE`).

---

## ▶️ Esempio pratico: Log delle modifiche su `customer`

### 1. Creare una tabella di log

```sql
CREATE TABLE customer_log (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT,
    azione VARCHAR(10),
    data TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

### 2. Trigger di INSERT, UPDATE, DELETE

```sql
DELIMITER $$

CREATE TRIGGER trg_customer_insert
AFTER INSERT ON customer
FOR EACH ROW
BEGIN
    INSERT INTO customer_log(customer_id, azione)
    VALUES (NEW.customer_id, 'INSERT');
END $$

CREATE TRIGGER trg_customer_update
AFTER UPDATE ON customer
FOR EACH ROW
BEGIN
    INSERT INTO customer_log(customer_id, azione)
    VALUES (NEW.customer_id, 'UPDATE');
END $$

CREATE TRIGGER trg_customer_delete
AFTER DELETE ON customer
FOR EACH ROW
BEGIN
    INSERT INTO customer_log(customer_id, azione)
    VALUES (OLD.customer_id, 'DELETE');
END $$

DELIMITER ;
```

---

## 🧪 Esercizio

Verifica il contenuto della tabella `customer_log` dopo aver inserito, aggiornato o cancellato un record da `customer`.

