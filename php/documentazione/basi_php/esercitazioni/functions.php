<?php
//
//function getVal(){
//
//	$hi = "hello";
//
//	return "test";
//}
//
//class X{
//	function __construct($myP) {
//		//
//	}
//}
//
//
//$hi = "hello";
//$hi = 4;
//
//
//
//function myFun($p1 = "test"){
//	//
//}
//
//function myFun2($p1 = new X("t")){
//	//
//}
//
//function myFun3($p1 = getVal()){
//	//
//}
//
//myFun();
//myFun(getVal());
//myFun(new stdClass());
//myFun($hi);

function myFunc2(string $p1){

	var_dump(func_get_args());
	var_dump(func_num_args());
	var_dump(func_get_arg(0));

	foreach(func_get_args() as $key => $value){

	}

	echo "x";
}

//echo myFunc2("first", "second", "third");
$var = "string";
$var = null;

myFunc2($var);
echo myFunc20($var);


// rigida
function myFunc3(string $p1):void{

}

myFunc3("dd");
// flessibile (1) - string or null
function myFunc4(?string $p1) : ?string{
	return $p1;
}
myFunc4("dd");

// flessibile (2) - string or null
function myFunc20(string | null $p1): string | null{
	return $p1;
}



// flessibile (3) - string or int
function myFunc21(string | int $p1): string | int{
	return $p1;
}

// flessibile(4) - string or int or bool
function myFunc22(string | int | bool $p1): string | int | bool{
	return $p1;
}
// UNION TYPE TypeScript


// flessibile(5) - qualunque tipo
function myFunc23(mixed $p1): mixed{ // any
	return $p1;
}

// flessibile(6) - equivale al mixed
function myFunc24($p1){

}

