<?php

# LOOPS
# Creare uno script per sommare tutti gli interi tra 0 e 30 e infine mostrare il risultato

$results = [];
$n = 1;

while($n <= 30){
	$results[] = $n;
	$n++;
}

print_r($results);

$somma = array_sum($results);

echo "somma: $somma";

//

$numbers = [0, 1, 2, 3, 4, 5, 6, 7, 9, 10, 11, 12]; // fino a 30.. ma mi sono annoiato..
$results = array_sum($numbers);

//

$max = 30;
$totale = 0;

for($i = 0; $i <= $max; $i++){
	$totale += $i;
}

echo "Risultato: $totale";