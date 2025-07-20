<?php

$like = ['Mario', 'Giuseppe', 'Giorgio', 'Anna'];

$l = count($like);

// BASE
if($l == 0)
	echo "no one like this" . PHP_EOL;
else if($l == 1)
	echo "$like[0] likes this";
else if($l == 2)
	echo "$like[0] and $like[1] like this";
else if($l == 3)
	echo "$like[0], $like[1] and $like[2] like this";
else
	echo "$like[0], $like[1] and ". $l-2 .' others like this';

// SWITCH
switch($l){
	case 0:
		echo "no one like this" . PHP_EOL;
		break;
	case 1:
		echo "$like[0] likes this";
		break;
	case 2:
		echo "$like[0] and $like[1] like this";
		break;
	case 3:
		echo "$like[0], $like[1] and $like[2] like this";
		break;
	default:
		echo "$like[0], $like[1] and ". $l-2 .' others like this';
}

// MATCH
echo match ( $l ) {
	0 => "no one like this" . PHP_EOL,
	1 => "$like[0] likes this",
	2 => "$like[0] and $like[1] like this",
	3 => "$like[0], $like[1] and $like[2] like this",
	default => "$like[0], $like[1] and " . $l - 2 . ' others like this',
};
