# PHP Basics - Riepilogo Concetti

Questo documento riassume i concetti base di PHP presentati nel file `basic.php`.

## Indice
- [Commenti](#commenti)
- [Costanti](#costanti)
- [Variabili](#variabili)
- [Funzioni](#funzioni)
- [Operatori](#operatori)
- [Comparatori](#comparatori)
- [Tipi Dinamici](#tipi-dinamici)
- [Controllo dei Valori Null](#controllo-dei-valori-null)
- [Stringhe](#stringhe)
- [Array](#array)

## Commenti

PHP supporta diversi tipi di commenti:

```php
// Commento a singola linea
# Altro commento a singola linea

/*
Commento 
multi-linea
*/

/**
 * Commento di documentazione
 * @return void
 */
```

## Costanti

Le costanti sono identificatori che rappresentano valori immutabili:

```php
const MY_CONST = "I am a constant";
const MY_CONST2 = 5;
```

## Variabili

In PHP, le variabili iniziano con il simbolo `$`:

```php
// Convenzioni di nomenclatura
$mia_variabile = "";  // snake_case
$miaVariabile = "";   // camelCase

// Dichiarazione e assegnazione
$e;                   // dichiarazione
$e = "test";          // assegnazione
$f = "test";          // dichiarazione-assegnazione
```

## Funzioni

Le funzioni permettono di organizzare il codice in blocchi riutilizzabili:

```php
// Funzione con accesso a variabile globale
function myFunction() {
    global $x;  // accesso alla variabile globale $x
    return $x + 1;
}

// Funzione con accesso a costante
function myFunction2() {
    return MY_CONST2 + 1;  // le costanti sono accessibili globalmente
}

// Funzione con variabile statica
function myFunction3() {
    static $t = 10;  // la variabile mantiene il valore tra le chiamate
    // operazioni su $t
    return $t;
}
```

### Scope delle Variabili

- **Global scope**: variabili dichiarate fuori dalle funzioni
- **Local scope**: variabili dichiarate all'interno delle funzioni
- **Static**: variabili che mantengono il loro valore tra chiamate successive della funzione

## Operatori

PHP offre vari operatori per manipolare i valori:

```php
// Operatori aritmetici
$t = $t + 1;
$t++;        // incremento

// Operatori di assegnazione composti
$t += 5;     // equivalente a $t = $t + 5
$t .= "5";   // concatenazione di stringhe (equivalente a $t = $t . "5")
```

## Comparatori

PHP fornisce operatori di confronto per valori e tipi:

```php
// Confronto di valore e tipo (strict)
if ("5" === 5) {  // false, perché i tipi sono diversi
    // codice
}

// Confronto solo di valore
if ("5" == 5) {   // true, PHP converte i tipi (type juggling)
    // codice
}
```

## Tipi Dinamici

PHP è un linguaggio a tipizzazione dinamica, il che significa che una variabile può cambiare tipo durante l'esecuzione:

```php
$a = 5;            // integer
$a = 5.5;          // float
$a = "test";       // string
$a = true;         // boolean
$a = null;         // null
$a = [];           // array
$a = new stdClass(); // object
```

## Controllo dei Valori Null

PHP offre diverse funzioni per verificare se una variabile è null o vuota:

```php
// isset() verifica se una variabile è stata dichiarata e non è null
if (!isset($nullValue)) {
    echo "EMPTY";
}

// is_null() verifica se una variabile è null
else if (is_null($nullValue)) {
    echo "EMPTY";
}

// empty() verifica se una variabile è considerata vuota
else if (empty($nullValue)) {
    echo "EMPTY";
}
```

## Stringhe

PHP supporta stringhe con doppi apici e singoli apici:

```php
$tt = "whohoo";

// Doppi apici: permettono l'interpolazione di variabili
$a = "ho una stringa in cui si può fare interpolazione $tt";

// Singoli apici: non permettono l'interpolazione, richiedono concatenazione
$a = 'ho una stringa in cui non si può fare interpolazione ' . $tt;
```

## Array

PHP supporta diversi tipi di array:

```php
// Array numerico (indici numerici)
$a = array(1, 2, 3);

// Array associativo (chiavi personalizzate)
$a = array("h" => 1, "b" => 2, "c" => 3);

// Array misto (combinazione di indici numerici e chiavi personalizzate)
$a = array(1, 2, 3, "h" => 1, "b" => 2, "c" => 3);

// Array multidimensionale (array di array)
$a = array(
    array(1, 2, 3),
    array(4, 5, 6),
    array(7, 8, 9),
    // altri elementi
);
```

Gli array in PHP sono estremamente flessibili e possono contenere elementi di tipi diversi.