# Funzioni in PHP

Le funzioni sono blocchi di codice riutilizzabili che eseguono operazioni specifiche. Sono fondamentali per organizzare il codice, evitare ripetizioni e creare applicazioni modulari e manutenibili.

## Indice
- [Sintassi di Base](#sintassi-di-base)
- [Parametri delle Funzioni](#parametri-delle-funzioni)
- [Tipi di Ritorno](#tipi-di-ritorno)
- [Scope delle Variabili](#scope-delle-variabili)
- [Funzioni Anonime e Closure](#funzioni-anonime-e-closure)
- [Arrow Functions](#arrow-functions)
- [Callback](#callback)
- [Funzioni Variabili](#funzioni-variabili)
- [Funzioni Pure e Non-Pure](#funzioni-pure-e-non-pure)
- [Best Practices](#best-practices)

## Sintassi di Base

La sintassi di base per definire una funzione in PHP è:

```php
function nomeFunzione($parametro1, $parametro2) {
    // Corpo della funzione
    return $risultato; // Opzionale
}

// Chiamata della funzione
$risultato = nomeFunzione($valore1, $valore2);
```

Esempio:

```php
function saluta($nome) {
    return "Ciao, $nome!";
}

echo saluta("Mario"); // Output: Ciao, Mario!
```

## Parametri delle Funzioni

### Parametri Obbligatori e Opzionali

```php
function esempio($parametroObbligatorio, $parametroOpzionale = "valore predefinito") {
    // Corpo della funzione
}

esempio("valore"); // Parametro opzionale assume il valore predefinito
esempio("valore", "altro valore"); // Parametro opzionale assume "altro valore"
```

### Type Hinting (Dichiarazione di Tipo)

PHP permette di specificare il tipo di dato atteso per i parametri:

```php
function somma(int $a, int $b) {
    return $a + $b;
}

// PHP 7.1+: parametri nullable (possono essere null)
function salutaPersona(?string $nome) {
    if ($nome === null) {
        return "Ciao, ospite!";
    }
    return "Ciao, $nome!";
}

// PHP 8.0+: union types (più tipi possibili)
function elaboraDato(string|int $dato) {
    // Elabora il dato
}

// PHP 8.0+: mixed (qualsiasi tipo)
function elaboraQualsiasi(mixed $dato) {
    // Elabora qualsiasi tipo di dato
}
```

### Parametri per Riferimento

Normalmente, i parametri vengono passati per valore (viene creata una copia). Usando `&` si passa per riferimento:

```php
function incrementa(&$numero) {
    $numero++;
}

$x = 5;
incrementa($x);
echo $x; // Output: 6
```

### Numero Variabile di Parametri

```php
// Metodo tradizionale
function somma() {
    $totale = 0;
    foreach (func_get_args() as $numero) {
        $totale += $numero;
    }
    return $totale;
}

// PHP 5.6+: operatore splat (...)
function sommaModerna(...$numeri) {
    return array_sum($numeri);
}

echo sommaModerna(1, 2, 3, 4); // Output: 10
```

## Tipi di Ritorno

PHP permette di specificare il tipo di dato restituito da una funzione:

```php
// Tipo di ritorno semplice
function quadrato(int $n): int {
    return $n * $n;
}

// Tipo di ritorno void (nessun valore restituito)
function saluta(string $nome): void {
    echo "Ciao, $nome!";
}

// Tipo di ritorno nullable
function trovaUtente(int $id): ?array {
    // Se l'utente non esiste, restituisce null
    // Altrimenti restituisce un array con i dati dell'utente
}

// Union types per il valore di ritorno (PHP 8.0+)
function elaboraDato(string $input): string|int {
    // Restituisce una stringa o un intero
}
```

## Scope delle Variabili

Le variabili definite all'interno di una funzione hanno uno scope locale:

```php
$globale = "Sono globale";

function test() {
    $locale = "Sono locale";
    echo $locale; // Funziona
    echo $globale; // Errore: variabile non definita
}

function testGlobal() {
    global $globale; // Accede alla variabile globale
    echo $globale; // Funziona
}

function testStatic() {
    static $contatore = 0; // Mantiene il valore tra le chiamate
    $contatore++;
    echo $contatore;
}

testStatic(); // Output: 1
testStatic(); // Output: 2
```

## Funzioni Anonime e Closure

Le funzioni anonime non hanno un nome e possono essere assegnate a variabili:

```php
$saluta = function($nome) {
    return "Ciao, $nome!";
};

echo $saluta("Luigi"); // Output: Ciao, Luigi!
```

Le closure possono "catturare" variabili dallo scope esterno:

```php
$messaggio = "Benvenuto";

$saluta = function($nome) use ($messaggio) {
    return "$messaggio, $nome!";
};

echo $saluta("Anna"); // Output: Benvenuto, Anna!
```

## Arrow Functions

PHP 7.4 ha introdotto le arrow functions, una sintassi più concisa per funzioni semplici:

```php
// Funzione anonima tradizionale
$quadrato = function($n) {
    return $n * $n;
};

// Arrow function equivalente
$quadrato = fn($n) => $n * $n;

// Le arrow functions catturano automaticamente le variabili esterne
$base = 10;
$aggiungiBase = fn($n) => $n + $base;
```

Le arrow functions sono ideali per operazioni semplici, specialmente quando usate come callback.

## Callback

Le callback sono funzioni passate come argomenti ad altre funzioni:

```php
function elaboraArray(array $array, callable $callback): array {
    $risultato = [];
    foreach ($array as $elemento) {
        $risultato[] = $callback($elemento);
    }
    return $risultato;
}

// Utilizzo con diverse callback
$numeri = [1, 2, 3, 4];

// Con funzione nominata
function quadrato($n) {
    return $n * $n;
}
$quadrati = elaboraArray($numeri, 'quadrato');

// Con funzione anonima
$cubi = elaboraArray($numeri, function($n) {
    return $n * $n * $n;
});

// Con arrow function
$doppi = elaboraArray($numeri, fn($n) => $n * 2);
```

Le callback possono essere:
- Nomi di funzioni come stringhe: `'nomeFunzione'`
- Funzioni anonime o arrow functions
- Array per metodi di oggetti: `[$oggetto, 'nomeMetodo']`
- Closure

## Funzioni Variabili

PHP permette di chiamare funzioni dinamicamente usando variabili:

```php
function saluta() {
    return "Ciao!";
}

$funzione = 'saluta';
echo $funzione(); // Output: Ciao!
```

## Funzioni Pure e Non-Pure

- **Funzioni Pure**: Restituiscono sempre lo stesso output per lo stesso input e non hanno effetti collaterali.
- **Funzioni Non-Pure**: Possono avere effetti collaterali (modificare variabili esterne, scrivere su file, ecc.) o restituire risultati diversi per lo stesso input.

```php
// Funzione pura
function somma(int $a, int $b): int {
    return $a + $b;
}

// Funzione non-pura (effetto collaterale)
function aggiungiADatabase($dato): void {
    // Modifica il database
}

// Funzione non-pura (risultato variabile)
function numeroRandom(): int {
    return rand(1, 10);
}
```

## Best Practices

1. **Nomi Descrittivi**: Usa nomi che descrivono chiaramente cosa fa la funzione.
2. **Responsabilità Singola**: Ogni funzione dovrebbe fare una cosa sola e farla bene.
3. **Lunghezza Limitata**: Mantieni le funzioni brevi e focalizzate.
4. **Documentazione**: Usa commenti PHPDoc per documentare parametri, tipi di ritorno e scopo.
5. **Gestione Errori**: Gestisci correttamente gli errori con try/catch o restituendo valori di errore.
6. **Type Hinting**: Usa le dichiarazioni di tipo per parametri e valori di ritorno.
7. **Valori Predefiniti Sensati**: Fornisci valori predefiniti ragionevoli per i parametri opzionali.
8. **Evita Effetti Collaterali**: Preferisci funzioni pure quando possibile.

```php
/**
 * Calcola il prezzo totale includendo le tasse.
 *
 * @param float $prezzo Il prezzo base del prodotto
 * @param float $aliquotaIva L'aliquota IVA (es. 0.22 per 22%)
 * @return float Il prezzo totale con IVA
 */
function calcolaPrezzoConIva(float $prezzo, float $aliquotaIva = 0.22): float {
    if ($prezzo < 0) {
        throw new InvalidArgumentException("Il prezzo non può essere negativo");
    }
    
    return $prezzo * (1 + $aliquotaIva);
}
```

Le funzioni sono uno strumento potente in PHP e padroneggiarne l'uso è fondamentale per scrivere codice di qualità, manutenibile e riutilizzabile.