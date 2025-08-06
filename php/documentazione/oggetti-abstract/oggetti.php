<?php

// Super Classe (che verrà ereditata --- potenzialmente da usare solo così ... ereditata
abstract class Shape {

	protected array $lati;

	public function calculatePerimetro(){
		return array_sum($this->lati);
	}

	public function calculateArea(){
		return $this->particularCalculateArea();
	}

	abstract protected function particularCalculateArea();
}

// Geometria
// <is a> Classificazione
class Quadrato extends Shape{ // Quadrato, Triangolo, Rettangolo... //Poligoni

	protected array $lati;

	public function __construct(float $lato0, float $lato1, float $lato2, float $lato3){
		// valida che mi passi i lati giusti..
		// validazione
		$this->lati = [$lato0,$lato1,$lato2,$lato3];
	}

	public function calculatePerimetro(){
		return array_sum($this->lati);
	}

	protected function particularCalculateArea() {
		$lato0 = $this->lati[0];
		$lato1 = $this->lati[1];

		return $lato0 * $lato1;
	}
}

$quadrato = new Quadrato(10, 10, 10, 10);
$quadrato->calculatePerimetro();
$quadrato->calculateArea();
// Seconda richiesta.. ora devi fare il triangolo...

class Triangolo extends Shape {
	private float $base;
	private float $altezza;

	public function __construct(float $base, float $altezza, float $lato0, float $lato1, float $lato2){
		//
		$this->lati = [$lato0,$lato1,$lato2];
		$this->base = $base;
		$this->altezza = $altezza;
	}

	protected function particularCalculateArea() {
		return $this->base * $this->altezza / 2;
	}
}

$triangolo = new Triangolo(10, 10, 10, 10);
$triangolo->calculatePerimetro();
$triangolo->calculateArea();

$quadrato = new Shape();