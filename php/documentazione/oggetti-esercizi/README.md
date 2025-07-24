# Riorganizza il Codice con le Classi

## 1 - Gestione di un Conto Bancario

Ecco il codice procedurale originale che gestisce un conto bancario:

```php
<?php

$accountOwner = "Mario Rossi";
$balance = 0;

function deposit(&$balance, $amount) {
	$balance += $amount;
}

function withdraw(&$balance, $amount) {
	if ($amount > $balance) {
		echo "Fondi insufficienti\n";
		return;
	}
	$balance -= $amount;
}

function getBalance($balance) {
	return $balance;
}

// Uso del sistema
deposit($balance, 1000);
withdraw($balance, 200);
echo "Saldo attuale per $accountOwner: " . getBalance($balance) . "€\n";
```

Questo codice utilizza:
- Variabili globali (`$accountOwner`, `$balance`)
- Funzioni che operano su queste variabili
- Passaggio di parametri per riferimento (`&$balance`)

## Perché Passare alle Classi?

L'approccio procedurale presenta alcuni limiti:

1. **Mancanza di incapsulamento**: I dati (variabili) sono separati dalle operazioni (funzioni) che li manipolano.
2. **Difficoltà di riutilizzo**: È difficile creare più conti bancari senza duplicare il codice.
3. **Mancanza di protezione dei dati**: Le variabili sono accessibili globalmente e possono essere modificate da qualsiasi parte del codice.
4. **Difficoltà di manutenzione**: Con l'aumentare della complessità, diventa difficile gestire il codice.

## Identificazione di Proprietà e Metodi per la Classe

Per convertire il codice in un approccio orientato agli oggetti, dobbiamo prima identificare:

1. **Proprietà** (dati che la classe deve gestire):
   - Nome del proprietario del conto (`$accountOwner`)
   - Saldo del conto (`$balance`)

2. **Metodi** (operazioni che la classe deve eseguire):
   - Deposito (`deposit()`)
   - Prelievo (`withdraw()`)
   - Ottenere il saldo (`getBalance()`)


## 2 - Gestione di un carrello (versione procedurale)

```php
<?php

$cart = [];

function addProduct(&$cart, $productName, $price, $quantity) {
    $cart[] = [
        'name' => $productName,
        'price' => $price,
        'quantity' => $quantity
    ];
}

function getTotal($cart) {
    $total = 0;
    foreach ($cart as $item) {
        $total += $item['price'] * $item['quantity'];
    }
    return $total;
}

// Uso
addProduct($cart, "Laptop", 800, 1);
addProduct($cart, "Mouse", 20, 2);

echo "Totale carrello: " . getTotal($cart) . "€\n";

```

## 3 - Gestione di studenti e voti (procedurale)

```php
<?php

$students = [];

function addStudent(&$students, $name, $grades) {
    $students[] = [
        'name' => $name,
        'grades' => $grades
    ];
}

function getAverage($grades) {
    return array_sum($grades) / count($grades);
}

function printReport($students) {
    foreach ($students as $student) {
        $average = getAverage($student['grades']);
        echo "Studente: {$student['name']}, Media voti: $average\n";
    }
}

// Uso
addStudent($students, "Luca", [7, 8, 9]);
addStudent($students, "Anna", [6, 7, 6]);

printReport($students);


```

