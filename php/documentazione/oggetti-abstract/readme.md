# Classi Astratte in PHP

## Cosa sono le Classi Astratte?

Le classi astratte in PHP sono un concetto fondamentale della programmazione orientata agli oggetti (OOP) che fornisce un modello per altre classi. Una classe astratta:

- Non può essere istanziata direttamente
- Contiene almeno un metodo astratto (dichiarato ma non implementato)
- Deve essere estesa da classi figlie che implementano tutti i metodi astratti
- Può contenere metodi concreti (con implementazione) e proprietà

## Sintassi

```php
abstract class NomeClasseAstratta {
    // Proprietà
    protected $proprietà;
    
    // Metodo concreto
    public function metodoConcreto() {
        // Implementazione
    }
    
    // Metodo astratto (senza implementazione)
    abstract public function metodoAstratto();
}
```

## Perché usare le Classi Astratte?

Le classi astratte sono utili quando:

1. **Vuoi definire un'interfaccia comune** per un gruppo di classi correlate
2. **Vuoi condividere codice** tra diverse classi senza utilizzare l'ereditarietà multipla
3. **Vuoi forzare l'implementazione** di certi metodi nelle classi figlie
4. **Vuoi definire un comportamento base** che può essere esteso o modificato

## Differenze tra Classi Astratte e Interfacce

| Caratteristica | Classe Astratta | Interfaccia |
|----------------|----------------|------------|
| Metodi | Può avere sia metodi astratti che concreti | Solo metodi astratti (prima di PHP 8.0) |
| Proprietà | Può avere proprietà | Solo costanti |
| Ereditarietà | Una classe può estendere solo una classe astratta | Una classe può implementare più interfacce |
| Visibilità | I metodi possono avere qualsiasi visibilità | I metodi sono implicitamente pubblici |

## Esempio Pratico

Nel nostro esempio, abbiamo creato una gerarchia di classi per rappresentare esseri viventi:

```php
abstract class EssereVivente {
    protected string $nome;
    
    public function __construct(string $nome) {
        $this->nome = $nome;
    }
    
    public function getNome(): string {
        return $this->nome;
    }
    
    public function respira() {
        echo "{$this->nome} sta respirando\n";
    }
    
    abstract public function mangia();
    abstract public function muove();
}
```

Questa classe astratta definisce:
- Una proprietà `$nome`
- Un costruttore concreto
- Un metodo concreto `getNome()`
- Un metodo concreto `respira()` che può essere sovrascritto
- Due metodi astratti `mangia()` e `muove()` che devono essere implementati

### Estensione di una Classe Astratta

Possiamo creare un'altra classe astratta che estende la prima:

```php
abstract class Pesce extends EssereVivente {
    public function respira() {
        $this->internalRespira();
    }
    
    abstract protected function internalRespira();
    
    public function muove() {
        echo "{$this->nome} nuota nell'acqua\n";
    }
}
```

Questa classe:
- Sovrascrive il metodo `respira()`
- Aggiunge un nuovo metodo astratto `internalRespira()`
- Implementa il metodo astratto `muove()`
- Lascia il metodo `mangia()` ancora astratto

### Implementazione Concreta

Infine, creiamo classi concrete che implementano tutti i metodi astratti:

```php
class Salmone extends Pesce {
    protected function internalRespira() {
        echo "{$this->nome} respira con le branchie\n";
    }
    
    public function mangia() {
        echo "{$this->nome} mangia piccoli pesci e insetti\n";
    }
}

class Cane extends EssereVivente {
    public function respira() {
        echo "{$this->nome} respira con i polmoni\n";
    }
    
    public function mangia() {
        echo "{$this->nome} mangia crocchette\n";
    }
    
    public function muove() {
        echo "{$this->nome} corre su quattro zampe\n";
    }
}
```

## Best Practices

1. **Usa le classi astratte per definire comportamenti comuni** tra classi correlate
2. **Implementa metodi concreti** per funzionalità condivise
3. **Dichiara metodi astratti** per funzionalità che devono essere implementate in modo specifico
4. **Considera l'uso di interfacce insieme alle classi astratte** per una maggiore flessibilità
5. **Segui il principio di sostituzione di Liskov**: le classi derivate dovrebbero essere sostituibili alle loro classi base

## Conclusione

Le classi astratte sono uno strumento potente in PHP per creare gerarchie di classi ben strutturate. Permettono di definire un'interfaccia comune e condividere codice, garantendo al contempo che le classi figlie implementino determinati comportamenti.