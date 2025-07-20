<?php

/** CLASSE - TIMBRO VS ISTANZA - OGGETTO - TIMBRATURA */
class Math {

	protected bool $absCalled = false;

	public function abs(int|float $number):int|float{
		return $this->internalAbs($number);
	}


	/** INCAPSULAMENTO */

	private int|float $lastAbsNumber;

	// getter - query
	public function getLastAbsNumber(){
		if($this->absCalled == false)
			throw new Exception("Non puoi accedere a LastAbsNumber se non chiami abs!!!!!!!");

		return $this->lastAbsNumber;
	}

	// setter - comando
	public function setLastAbsNumber(int|float $number):void{
		$this->internalAbs($number);
	}

	/** METODI PRIVATI */

	/** DRY --- DO NOT REPEAT YOURSELF!!!!!! **/

	private function internalAbs(int|float $number):int|float{
		if($number > 1000){
			throw new Exception("Non puoi usare questa funzione con numeri cosi alti");
		}
		$this->absCalled = true;
		return abs($number);
	}
}


/** EREDITARIETA' */
class MyMath extends Math{

	public function ceil(float $number){
		return ceil($number);
	}

	public function abs(int|float $number):int|float{
		$this->absCalled = true;
		return abs($number);
	}

}


// Antonio code
$math = new MyMath(); // istanza - oggetto

$result = $math->abs(-20);
$ceilResult = $math->ceil(5.4);
$lastResult = $math->getLastAbsNumber();

// Irene code
$math1 = new Math(); // istanza - oggetto

$lastResult = $math1->getLastAbsNumber(); // null
$math1->setLastAbsNumber(is_null($lastResult) ? 22 : $lastResult);
$ceilResult = $math1->ceil(5.4); // NO! NON PUOI USARE QUESTO METODO!!!
$lastResult = $math1->getLastAbsNumber(); // 22

echo "ha veramente funzionato!! Ora posso usare abs.. senza diventare matto!!! grazie Gabri God";