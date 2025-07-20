<?php

# LOOPS
# Creare uno script per stampare la riga 1-2-3-4-5-6-7-8-9-10 attraverso i loop..

$rounds = 11;

for($i = 1; $i <= $rounds; $i++){

	echo $i;

	if($i < $rounds)
		echo '-';
}

echo PHP_EOL;

for($i = 1; $i <= $rounds; $i++){

	echo $i;

	if($i == $rounds)
		continue;

	echo '-';
}

//
echo PHP_EOL;

$i = 1;

while($i <= 10){
	echo $i;

	if ($i < 10){
		echo '-';
	}

	$i++;
}
