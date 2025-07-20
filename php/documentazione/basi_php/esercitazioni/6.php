<?php

// ARRAY

// MAPPING
$color0 = array("red", "blue", "green", "white", "black");
// FAT ARROW FUNCTION
$color1 = array_map(fn($c) => "<span style='color:$c'>$c</span>", $color0);

$testo = "The memory of that scene for me is like a frame of 
 film forever frozen at that moment: the $color1[0] carpet, the $color1[2] lawn, the $color1[3] house, the leaden sky. 
 The new ". colorWord($color0[1], "president") ." and his first lady. - Richard M. Nixon";

// bonus...
// explode del testo (array explode)
//


$testoArray = explode(" ", $testo);

foreach($testoArray as $word){
	// do something...
	// applichiamo la sostituzione
}

$testo = implode(" ", $testoArray);






function colorWord($color, $word){
	return "<span style='color:$color'>$word</span>";
}

?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>page</title>
</head>
<body>
<div style="background:pink">
	<?=$testo?>
</div>
</body>
</html>


