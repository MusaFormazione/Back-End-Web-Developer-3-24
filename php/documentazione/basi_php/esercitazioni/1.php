<?php

# Scrivere un programma che trovi il maggiore tra 3 numeri
# Logica condizionale

// 1 --- la $number1 è più grande.. perchè il valore è più grande della $number2 e contemporaneamente della $number3
//$number1 = 39;
//$number2 = 15;
//$number3 = 12;

// 2 la $number2 è più grande.. perchè il valore è più grande della $number1 e contemporaneamente della $number3
//$number1 = 15;
//$number2 = 39;
//$number3 = 12;

// 3 la $number3 è più grande.. perchè il valore è più grande della $number2 e contemporaneamente della $number1
$number1 = 15;
$number2 = 12;
$number3 = 39;

// 4 Nessuno dei 3 è il più grande... perchè il valore è uguale
$number1 = 39;
$number2 = 39;
$number3 = 39;

// 1
//$number1 = 39;
//$number2 = 15;
//$number3 = 15;

// 2
//$number1 = 15;
//$number2 = 39;
//$number3 = 15;

// 3
//$number1 = 15;
//$number2 = 15;
//$number3 = 39;

// 4
//$number1 = 39;
//$number2 = 39;
//$number3 = 15;
//
//$number1 = 15;
//$number2 = 39;
//$number3 = 39;

//$number1 = 15;
//$number2 = 15;
//$number3 = 39;


// 5 caso stringhe
//$number1 = "39";
//$number2 = "16";
//$number3 = "15";

//$number1 = "39";
//$number2 = "sei";
//$number3 = "15";

// ASSEGNAZIONE DENTRO IL TERNARIO -- EVITARE
//$result = ($number1 < $number2 && $number2 > $number3) ?
//	$number2 . " Sono il numero maggiore" : // true
//	"Nessun numero maggiore"; // false


// PSEUDO-CODE #1
// 1 la $number1 è più grande.. perchè il valore è più grande della $number2 e contemporaneamente della $number3
// 2 la $number2 è più grande.. perchè il valore è più grande della $number1 e contemporaneamente della $number3
// 3 la $number3 è più grande.. perchè il valore è più grande della $number2 e contemporaneamente della $number1
// 4 Nessuno dei 3 è il più grande... perchè il valore è uguale




// DIRTY CODE #2 (MAKE IT WORKS!)
//if($number1 > $number2 && $number1 > $number3)
//	echo '$number1' . " " . $number1;
//if($number2 > $number1 && $number2 > $number3)
//	echo '$number2' . " " . $number2;
//if($number3 > $number1 && $number3 > $number2)
//	echo '$number3' . " " . $number3;
//if($number1 == $number2 && $number1 > $number3)
//	echo '$number1 e $number2'  . " uguali " . $number1;
//if($number1 == $number3 && $number1 > $number3)
//	echo '$number1 e $number3'  . " uguali " . $number1;
//if($number2 == $number3 && $number2 > $number1)
//	echo '$number2 e $number3'  . " uguali " . $number2;
//if($number1 == $number2 && $number1 == $number3 &&
//   $number2 == $number3 && $number2 == $number1 &&
//   $number3 == $number1 && $number3 == $number2)
//	echo 'sono uguali';

// REFACTORING #3


// EARLY RETURN (EARLY EXIT)

if(!is_numeric($number1) || !is_numeric($number2) || !is_numeric($number3)){
	echo "Argomento/i errato/i";
	exit(1);
}

else if($number1 == $number2 && $number2 == $number3)
	echo 'sono uguali';

else if($number1 >= $number2 && $number1 > $number3){
	$equalCase = $number1 == $number2 ? 'e $number2' : '';
	echo '$number1 ' . $equalCase . " " . $number1;
}

else if($number2 >= $number1 && $number2 > $number3){
	$equalCase = $number1 == $number2 ? 'e $number1' : '';
	echo '$number2 ' . $equalCase . " " . $number2;
}

else{
	$equalCase = $number1 == $number3 ?
		'e $number1' :
		($number2 == $number3 ? 'e $number2' : '');

	echo '$number3 ' . $equalCase . " " . $number3;
}
