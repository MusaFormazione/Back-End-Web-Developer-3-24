<?php


//$accountOwner = "Mario Rossi";
//$balance = 0;
//
//function deposit(&$balance, $amount) {
//	$balance += $amount;
//}
//
//function withdraw(&$balance, $amount) {
//	if ($amount > $balance) {
//		echo "Fondi insufficienti\n";
//		return;
//	}
//	$balance -= $amount;
//}
//
//function getBalance($balance) {
//	return $balance;
//}
//
//// Uso del sistema
//deposit($balance, 1000);
//withdraw($balance, 200);
//echo "Saldo attuale per $accountOwner: " . getBalance($balance) . "€\n";

class ContoCorrente{

	private string $proprietario;
	private float $saldo = 0;
	private int $operazione = 0;

	public function __construct(string $nome, float $soldi){
		$this->proprietario = $nome;
		$this->aggiungiSoldi($soldi);
	}

	public function aggiungiSoldi( float $soldi ):void {
		if($soldi <= 0){
			throw new Exception("Impossibile ricaricare il conto");
		} else {
			$this->saldo += $soldi;
			$this->operazione++;
			echo "operazione $this->operazione: hai depositato $soldi";
		}
	}

	public function prelievoFondi( float $soldi){
		if($soldi > $this->saldo){
			throw new Exception("Non puoi prelevare più soldi di quanti ne hai!!!!");
		} else {
			$this->saldo -= $soldi;
			echo "operazione $this->operazione: hai prelevato $soldi";
		}
	}

	public function getSaldo(){
		return $this->saldo;
	}
}

$conto1 = new ContoCorrente("Mario Rossi", 1000);
$conto1->prelievoFondi(50);
echo PHP_EOL;
echo $conto1->getSaldo() . PHP_EOL;
$conto1->aggiungiSoldi(100);
echo PHP_EOL;
echo $conto1->getSaldo() . PHP_EOL;
