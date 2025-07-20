<?php

# Scrivere un programma per trovare numeri pari o dispari

$numero1 = 5;
$numero2 = 2;
$numero3 = 4;

// 5
$numero1 / 2; // 2 il resto di 1
$numero3 / 2; // 2 il resto di 0
// è divisibile per 2.. assumiamo..

if($numero1%2 == 0)
	echo "$numero1 \n";

if($numero2%2 == 0)
	echo "$numero2 \n";

if($numero3%2 == 0)
	echo "$numero3 \n";


// Gabriele

$numbers = [2, 5, 12, 17, 22, 35];

foreach($numbers as $value){ //
	if($value%2==0){
		echo $value . " PARI" . PHP_EOL;
	} else if($value%2==1){
		echo "$value PARI" . PHP_EOL;
	}
}

// foreach($numbers as $key => $value)
// foreach($numbers as $value)

//for($i = 0; $i < count($numbers); $i++){
//	// $numbers[$i];
//}