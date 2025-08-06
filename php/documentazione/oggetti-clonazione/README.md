# Clonazione in PHP

La clonazione in PHP è un meccanismo che permette di creare una copia di un oggetto esistente. Questo processo è particolarmente utile quando si desidera lavorare con una copia indipendente di un oggetto senza modificare l'originale.

## Concetti base della clonazione

In PHP, la clonazione di un oggetto si effettua utilizzando la parola chiave `clone`:

```php
$oggetto2 = clone $oggetto1;
```

Quando si clona un oggetto:
- Viene creata una copia superficiale (shallow copy) dell'oggetto originale
- La nuova istanza ha le stesse proprietà con gli stessi valori dell'originale
- Le due istanze sono indipendenti: modificare una non influisce sull'altra

## Clonazione superficiale vs profonda

### Clonazione superficiale (default)

Per default, PHP esegue una clonazione superficiale, che significa:
- Le proprietà contenenti tipi primitivi (int, string, bool, ecc.) vengono copiate
- Le proprietà contenenti riferimenti ad altri oggetti mantengono il riferimento allo stesso oggetto

```php
<?php
class Indirizzo {
    public $via;
    public $città;
    
    public function __construct($via, $città) {
        $this->via = $via;
        $this->città = $città;
    }
}

class Persona {
    public $nome;
    public $indirizzo;
    
    public function __construct($nome, Indirizzo $indirizzo) {
        $this->nome = $nome;
        $this->indirizzo = $indirizzo;
    }
}

// Creiamo un oggetto
$indirizzo = new Indirizzo("Via Roma 1", "Milano");
$persona1 = new Persona("Mario", $indirizzo);

// Cloniamo l'oggetto
$persona2 = clone $persona1;
$persona2->nome = "Luigi";

// Modifichiamo l'indirizzo della seconda persona
$persona2->indirizzo->via = "Via Verdi 2";

// Questo modificherà anche l'indirizzo della prima persona!
echo $persona1->indirizzo->via; // Output: "Via Verdi 2"
?>
```

### Clonazione profonda (deep clone)

Per ottenere una clonazione profonda, dove anche gli oggetti contenuti vengono clonati, è necessario implementare il metodo magico `__clone()`:

```php
<?php
class Persona {
    public $nome;
    public $indirizzo;
    
    public function __construct($nome, Indirizzo $indirizzo) {
        $this->nome = $nome;
        $this->indirizzo = $indirizzo;
    }
    
    public function __clone() {
        // Cloniamo anche l'oggetto Indirizzo
        $this->indirizzo = clone $this->indirizzo;
    }
}

// Ora con la clonazione profonda
$indirizzo = new Indirizzo("Via Roma 1", "Milano");
$persona1 = new Persona("Mario", $indirizzo);

// Cloniamo l'oggetto
$persona2 = clone $persona1;
$persona2->nome = "Luigi";

// Modifichiamo l'indirizzo della seconda persona
$persona2->indirizzo->via = "Via Verdi 2";

// L'indirizzo della prima persona rimane invariato
echo $persona1->indirizzo->via; // Output: "Via Roma 1"
?>
```

## Il metodo magico `__clone()`

Il metodo `__clone()` viene chiamato automaticamente dopo che un oggetto è stato clonato. Questo permette di:

1. Personalizzare il processo di clonazione
2. Implementare la clonazione profonda per le proprietà che contengono oggetti
3. Eseguire operazioni aggiuntive sulla copia appena creata

```php
<?php
class Esempio {
    public $id;
    public $data;
    public $oggetto;
    
    public function __clone() {
        // Generiamo un nuovo ID per la copia
        $this->id = uniqid();
        
        // Aggiorniamo la data alla data corrente
        $this->data = new DateTime();
        
        // Cloniamo anche l'oggetto contenuto
        if ($this->oggetto !== null) {
            $this->oggetto = clone $this->oggetto;
        }
    }
}
?>
```

## Casi d'uso comuni

La clonazione in PHP è utile in diversi scenari:

1. **Pattern Prototype**: Creare nuovi oggetti clonando un prototipo esistente
2. **Snapshot**: Salvare lo stato di un oggetto in un determinato momento
3. **Operazioni su copie**: Eseguire operazioni su una copia senza modificare l'originale
4. **Duplicazione con modifiche minori**: Creare un nuovo oggetto simile a uno esistente con piccole differenze

## Esempio pratico: Pattern Prototype

```php
<?php
abstract class Documento {
    protected $titolo;
    protected $contenuto;
    
    public function __construct($titolo, $contenuto) {
        $this->titolo = $titolo;
        $this->contenuto = $contenuto;
    }
    
    public function getTitolo() {
        return $this->titolo;
    }
    
    public function getContenuto() {
        return $this->contenuto;
    }
    
    public function setTitolo($titolo) {
        $this->titolo = $titolo;
    }
    
    public function setContenuto($contenuto) {
        $this->contenuto = $contenuto;
    }
    
    abstract public function duplica();
}

class DocumentoTesto extends Documento {
    private $formato;
    
    public function __construct($titolo, $contenuto, $formato = "txt") {
        parent::__construct($titolo, $contenuto);
        $this->formato = $formato;
    }
    
    public function getFormato() {
        return $this->formato;
    }
    
    public function duplica() {
        return clone $this;
    }
}

// Utilizzo
$originale = new DocumentoTesto("Relazione", "Contenuto della relazione", "docx");
$copia = $originale->duplica();
$copia->setTitolo("Relazione (copia)");

echo $originale->getTitolo(); // Output: "Relazione"
echo $copia->getTitolo();     // Output: "Relazione (copia)"
?>
```

## Limitazioni e considerazioni

- La clonazione non funziona con risorse esterne come connessioni di database o handle di file
- È necessario prestare attenzione alla gestione della memoria, specialmente quando si clonano oggetti grandi o complessi
- In alcuni casi, potrebbe essere più efficiente utilizzare altri metodi per creare copie di oggetti, come la serializzazione/deserializzazione

## Confronto con altri approcci

| Approccio | Vantaggi | Svantaggi |
|-----------|----------|-----------|
| Clonazione | Veloce, mantiene il tipo dell'oggetto | Richiede implementazione di `__clone()` per deep copy |
| Serializzazione/Deserializzazione | Garantisce deep copy, può persistere | Più lento, potenziali problemi con risorse |
| Costruttore di copia | Controllo esplicito | Richiede implementazione manuale |

La clonazione è uno strumento potente in PHP che, se utilizzato correttamente, può semplificare molti aspetti della programmazione orientata agli oggetti.