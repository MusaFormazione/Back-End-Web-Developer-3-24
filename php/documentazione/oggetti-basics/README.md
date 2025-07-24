# Guida agli Oggetti in PHP

Questa guida spiega i concetti fondamentali della programmazione orientata agli oggetti (OOP) in PHP, basandosi sugli esempi presenti nel file `oggetti-1.php`.

## Concetti Base

### Classi e Oggetti

In PHP, una **classe** è un modello che definisce le caratteristiche e i comportamenti di un tipo di oggetto. Funziona come un "timbro" che può essere utilizzato per creare molteplici istanze.

Un **oggetto** è un'istanza di una classe. Quando si crea un oggetto, si sta essenzialmente "timbrando" una nuova entità basata sul modello della classe.

```php
// Definizione di una classe
class Math {
    // Proprietà e metodi...
}

// Creazione di un oggetto (istanza della classe)
$math = new Math();
```

### Proprietà e Metodi

Le **proprietà** sono variabili che appartengono a una classe.

I **metodi** sono funzioni che appartengono a una classe.

```php
class Math {
    // Proprietà
    protected bool $absCalled = false;
    private int|float $lastAbsNumber;
    
    // Metodo
    public function abs(int|float $number): int|float {
        return $this->internalAbs($number);
    }
}
```

## Modificatori di Accesso

PHP supporta tre modificatori di accesso che determinano la visibilità di proprietà e metodi:

1. **public**: accessibile da ovunque
2. **protected**: accessibile solo dalla classe stessa e dalle classi che la estendono
3. **private**: accessibile solo dalla classe stessa

```php
class Math {
    public function abs() { /* ... */ }      // Accessibile da ovunque
    protected bool $absCalled = false;       // Accessibile dalla classe e dalle sue estensioni
    private function internalAbs() { /* ... */ } // Accessibile solo dalla classe Math
}
```

## Incapsulamento

L'**incapsulamento** è il concetto di nascondere i dettagli implementativi di una classe e fornire un'interfaccia pubblica per interagire con essa. Si realizza spesso con getter e setter.

```php
class Math {
    private int|float $lastAbsNumber;
    
    // Getter (query) - ottiene il valore
    public function getLastAbsNumber() {
        if($this->absCalled == false)
            throw new Exception("Non puoi accedere a LastAbsNumber se non chiami abs!!!!!!!");
        return $this->lastAbsNumber;
    }
    
    // Setter (comando) - imposta il valore
    public function setLastAbsNumber(int|float $number): void {
        $this->internalAbs($number);
    }
}
```

## Ereditarietà

L'**ereditarietà** permette a una classe di ereditare proprietà e metodi da un'altra classe. La classe che eredita è chiamata "classe figlia" o "sottoclasse", mentre la classe da cui eredita è chiamata "classe genitore" o "superclasse".

```php
// Classe genitore
class Math {
    // ...
}

// Classe figlia che eredita da Math
class MyMath extends Math {
    // Nuovi metodi
    public function ceil(float $number) {
        return ceil($number);
    }
    
    // Sovrascrittura di metodi esistenti
    public function abs(int|float $number): int|float {
        $this->absCalled = true;
        return abs($number);
    }
}
```

## Istanziazione e Utilizzo degli Oggetti

Per utilizzare una classe, è necessario creare un'istanza (oggetto) e quindi chiamare i suoi metodi:

```php
// Creazione di un oggetto della classe MyMath
$math = new MyMath();

// Chiamata ai metodi dell'oggetto
$result = $math->abs(-20);
$ceilResult = $math->ceil(5.4);
$lastResult = $math->getLastAbsNumber();
```

## Principi di Programmazione

### DRY (Don't Repeat Yourself)

Il principio DRY incoraggia a evitare la duplicazione del codice. Nel nostro esempio, il metodo `internalAbs()` viene utilizzato sia da `abs()` che da `setLastAbsNumber()`, evitando così la duplicazione della logica.

```php
private function internalAbs(int|float $number): int|float {
    if($number > 1000) {
        throw new Exception("Non puoi usare questa funzione con numeri cosi alti");
    }
    $this->absCalled = true;
    return abs($number);
}
```

## Gestione delle Eccezioni

PHP permette di gestire situazioni eccezionali lanciando e catturando eccezioni:

```php
public function getLastAbsNumber() {
    if($this->absCalled == false)
        throw new Exception("Non puoi accedere a LastAbsNumber se non chiami abs!!!!!!!");
    return $this->lastAbsNumber;
}
```

## Dichiarazioni di Tipo

PHP supporta le dichiarazioni di tipo per parametri e valori di ritorno, migliorando la robustezza del codice:

```php
public function abs(int|float $number): int|float {
    // ...
}
```

In questo esempio, `int|float` indica che il parametro e il valore di ritorno possono essere sia interi che numeri a virgola mobile.

## Conclusione

La programmazione orientata agli oggetti in PHP offre un modo potente e organizzato per strutturare il codice, promuovendo la riusabilità, la manutenibilità e la chiarezza. Attraverso concetti come classi, oggetti, incapsulamento ed ereditarietà, è possibile creare applicazioni PHP robuste e scalabili.