<?php
/**
 * Esempio di utilizzo delle classi astratte in PHP
 * 
 * Le classi astratte servono come modelli che non possono essere istanziati direttamente
 * ma devono essere estesi da classi concrete che implementano i metodi astratti.
 */

// Classe astratta base che definisce la struttura per tutti gli esseri viventi
abstract class EssereVivente {
    // Proprietà concreta
    protected string $nome;
    
    // Costruttore concreto
    public function __construct(string $nome) {
        $this->nome = $nome;
    }
    
    // Metodo concreto che può essere ereditato
    public function getNome(): string {
        return $this->nome;
    }
    
    // Metodo concreto che può essere sovrascritto
    public function respira() {
        echo "{$this->nome} sta respirando\n";
    }
    
    // Metodi astratti che DEVONO essere implementati dalle classi figlie
    abstract public function mangia();
    abstract public function muove();
}

// Non è possibile istanziare direttamente una classe astratta
// $essereVivente = new EssereVivente("Essere"); // Questo genererebbe un errore

// Classe astratta intermedia che estende EssereVivente
abstract class Pesce extends EssereVivente {
    // Sovrascrive il metodo respira
    public function respira() {
        // Delega l'implementazione specifica al metodo astratto
        $this->internalRespira();
    }
    
    // Nuovo metodo astratto che le classi figlie devono implementare
    abstract protected function internalRespira();
    
    // Implementa uno dei metodi astratti richiesti dalla classe genitore
    public function muove() {
        echo "{$this->nome} nuota nell'acqua\n";
    }
    
    // Il metodo mangia() rimane astratto e dovrà essere implementato dalle classi figlie
}

// Classe concreta che estende la classe astratta Pesce
class Salmone extends Pesce {
    // Implementa il metodo astratto della classe genitore
    protected function internalRespira() {
        echo "{$this->nome} respira con le branchie\n";
    }
    
    // Implementa il metodo astratto rimanente
    public function mangia() {
        echo "{$this->nome} mangia piccoli pesci e insetti\n";
    }
}

// Classe concreta che estende direttamente EssereVivente
class Cane extends EssereVivente {
    // Sovrascrive il metodo concreto
    public function respira() {
        echo "{$this->nome} respira con i polmoni\n";
    }
    
    // Implementa i metodi astratti richiesti
    public function mangia() {
        echo "{$this->nome} mangia crocchette\n";
    }
    
    public function muove() {
        echo "{$this->nome} corre su quattro zampe\n";
    }
}

// Esempi di utilizzo
$salmone = new Salmone("Salmone Rosso");
$salmone->respira();
$salmone->mangia();
$salmone->muove();

$cane = new Cane("Rex");
$cane->respira();
$cane->mangia();
$cane->muove();