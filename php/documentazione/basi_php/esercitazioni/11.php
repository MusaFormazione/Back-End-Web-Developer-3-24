<?php

# Scrivi un programma che dato una variabile (s) contenente
# una stringa a piacere
# (come hello), e un’altra variabile (n), contenente un intero,
# stampi n volte il valore di s.

$myVar = "ma che bella lezione";
$n = 5;

for($i = 0; $i < $n; $i++){
	echo $i + 1 . ') ' . $myVar . PHP_EOL;
}
