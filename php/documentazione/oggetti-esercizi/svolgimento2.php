<?php
//$cart = [];

//function addProduct( &$cart, $productName, $price, $quantity ) {
//	$cart[] = [
//		'name'     => $productName,
//		'price'    => $price,
//		'quantity' => $quantity
//	];
//}

//function getTotal( $cart ) {
//	$total = 0;
//	foreach ( $cart as $item ) {
//		$total += $item['price'] * $item['quantity'];
//	}
//
//	return $total;
//}
//
//// Uso
//addProduct( $cart, "Laptop", 800, 1 );
//addProduct( $cart, "Mouse", 20, 2 );
//
//echo "Totale carrello: " . getTotal( $cart ) . "€\n";


class Carrello{

	private array $prodotti = [];

	private string $nome;

	private int $numeroArticoli;


	public function __construct(string $nome){
		$this->nome = $nome;
	}

	public function addProduct( string $prodotto, float $price, int $quantity ){
		if($prodotto == "" || $price <= 0 || $quantity <= 0){
			throw new Exception("Impossibile aggiungere elemento");
		}

		$this->prodotti[] = [
			"nome" => $prodotto,
			"prezzo" => $price,
			"quantità" => $quantity
		];

		echo "Aggiunto prodotto";
	}

	public function getTotal(){

		$total = 0;

		foreach($this->prodotti as $prodotto){
			$total += $prodotto['prezzo'] * $prodotto['quantità'];
		}

		return $total;
	}
}

$carrello = new Carrello("Mario Rossi");
$carrello->addProduct("computer", 400, 1);
$carrello->addProduct("mouse", 10, 1);
echo "Totale Carrello : " . $carrello->getTotal();