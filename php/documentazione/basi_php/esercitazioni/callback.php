<?php


function elevate(array $numbers):array{
	foreach($numbers as $key=>$value){
		$numbers[$key] = $value * $value;
	}
	return $numbers;
}

function elevateA(callable $operation, array $numbers):array{

	foreach($numbers as $key => $value){
		$numbers[$key] = $operation($value);
	}

	return $numbers;
}

var_dump(elevateA(fn($n) => $n * $n, [20, 202, 2020]));
//elevateA(fn($n) => $n + $n, [20, 202, 2020]);
//elevateA(function ($n) {
//	// if
//	return $n + $n;
//}, [20, 202, 2020]);
