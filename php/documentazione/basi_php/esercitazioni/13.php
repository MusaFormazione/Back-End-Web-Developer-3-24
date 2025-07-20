<?php

# Sapendo che una stringa si può considerare come un elenco o array di caratteri,
# e che per ottenere la lunghezza di una stringa si può utilizzare la funzione strlen(s),
# date due variabile s0 e s1, scrivere uno script che per true se le due stringhe cominciano
# e finiscono con al stessa lettera, false se invece questo non è vero.

$s0 = "great blue heron";
$s1 = "garlic naan";

function matchChar($s0, $s1){
	if($s0[0] == $s1[0] && $s0[strlen($s0) - 1] == $s1[strlen($s1) - 1]){
		return true;
	} else
		return false;
}

$test = matchChar($s0, $s1);

var_dump($test);