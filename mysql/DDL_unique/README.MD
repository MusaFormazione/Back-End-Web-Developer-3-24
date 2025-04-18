# Vincoli UNIQUE in MySQL

Il vincolo `UNIQUE` viene utilizzato per garantire che tutti i valori in una colonna (o combinazione di colonne) siano **univoci**.

## ✅ Dichiarazione diretta nella colonna

```sql
CREATE TABLE clienti (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(150) UNIQUE
);
```

## ✅ Dichiarazione tramite CONSTRAINT

```sql
CREATE TABLE clienti (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(150),
    CONSTRAINT uniq_email UNIQUE (email)
);
```

## ✅ Dichiarazione tramite UNIQUE INDEX

```sql
CREATE UNIQUE INDEX idx_email ON clienti(email);
```

## ✅ Vincolo su più colonne

```sql
CREATE TABLE noleggi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cliente_id INT,
    veicolo_id INT,
    data_inizio DATETIME,
    CONSTRAINT uniq_noleggio UNIQUE (cliente_id, veicolo_id, data_inizio)
);
```

## ✅ Aggiungere vincolo dopo la creazione

```sql
ALTER TABLE clienti
ADD CONSTRAINT uniq_email UNIQUE (email);
```

## 🔎 Verifica dei vincoli UNIQUE

```sql
SHOW INDEX FROM clienti WHERE Non_unique = 0;
```

## ℹ️ Nota

- In MySQL, un vincolo `UNIQUE` crea **automaticamente un indice** unico.
- È possibile dare un **nome al vincolo** per facilitarne la gestione.
