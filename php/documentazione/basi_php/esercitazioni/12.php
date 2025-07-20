<?php


# Dato un set di numeri all’interno di un array, scrivi un programma che ritorni lo stesso set,
# ma con il loro valore invertito (1 diventa -1).
# [1, 2, 3, 4, 5] --> [-1, -2, -3, -4, -5]

// map

$numeri = [1, 2, 3, 4, 5];

$numeri_inversi = [];

//foreach($numeri as $n){
//	$numeri_inversi[] = $n * (-1);
//}
foreach($numeri as $n){
	$numeri_inversi[] = $n * -1;
}

var_dump($numeri_inversi);