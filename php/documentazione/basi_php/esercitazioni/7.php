<?php

// ARRAY
// Scrivere uno script che mostri tutti i colori presenti nel precedente array, prima in colonna, e poi in riga separati da una virgola.

$color = array('white', 'green', 'red', 'blue', 'black');

// white
// green


// white,green,...

foreach($color as $c){
	echo $c . PHP_EOL;
}

echo PHP_EOL;

foreach($color as $c){
	if($c == $color[count($color) - 1])
		echo "$c!";
	else
		echo "$c, ";
}