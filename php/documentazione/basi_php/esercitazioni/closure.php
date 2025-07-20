<?php


$foo = function() {
	return rand(0, 20);
};

$foo1 = function() {
	echo "hello";
};

//echo $foo();

function iDoSomethingForYou(callable $callback){
	$x = 1;
	// logic here!!
	$callback();
}


function iPrintSomethingForYou(callable $callback){
	$x = 1;
	// logic here!!
	echo $callback($x);
}


iDoSomethingForYou($foo1); // OK
iDoSomethingForYou(function() { // callback
	echo "test";
}); // OK

$a = 20;
 // catturare nallo scope della closure il valore esterno
iDoSomethingForYou(function() use($foo, $a) { // CLOSURE!!!
	echo $foo() > 10 ? "OK" : "KO";
}); // OK


// FAT-ARROW FUNCTION (UN MODO PER RENDERE IL CODICE PI# LEGGIBILE)
// IN ALCUNI CONTESTI NON LA PUOI USARE:
// QUANDO LA CLOSURE E' UNA FUNZIONE NON-PURA.... NON RITORNA VALORE

iPrintSomethingForYou(fn($a) => $foo() > $a ? "OK" : $foo() ); // OK

// CHIUSURA !!!