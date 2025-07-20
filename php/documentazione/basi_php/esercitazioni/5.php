<?php

// LOOPS
# Creare uno script che costruisca il seguente pattern

// *
// * *
// * * *
// * * * *
// * * * * *

$riga = 5;

for($i=1; $i <= $riga; $i++){
	for($j = 0; $j < $i; $j++){

		if($j != 0){
			echo ' ';
		}

		echo '*';
	}

	echo "\n";
}