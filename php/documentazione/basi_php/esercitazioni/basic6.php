<?php

function elevateNumbersCommand(array &$numbers):void{

	foreach($numbers as $key => $value){
		$numbers[$key] = $value * $value;
	}

}

function elevateNumbersQuery(array $numbers):array{
	$results = [];

	foreach($numbers as $value){
		$results[] = $value * $value;
	}

	return $results;
}

function elevateNumbersQueryArrayMap(array $numbers):array{
	return array_map(fn($n) => $n * $n, $numbers);
}

function modifyNumberQueryOurCallback(Callable $operation, array $elements):array{
	return $operation($elements);
}

function modifyNumberQueryOurCallback2(Callable $operation, array $elements):array{
	foreach($elements as $key => $element){
		$elements[$key] = $operation($element);
	}
	return $elements;
}



$array1 = [12, 9, 18];
//elevateNumbersCommand($array1);
//$array2 = elevateNumbersQueryArrayMap($array1);
//var_dump($array2);
//var_dump($array1);
var_dump(modifyNumberQueryOurCallback("elevateNumbersQueryArrayMap", [2, 3, 9]));
var_dump(modifyNumberQueryOurCallback2(fn($n) => $n + 2, [2, 3, 9]));

