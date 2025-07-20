<?php


$color1 = array('white', 'green', 'red', 'blue', 'black', 'yellow', 'purple');

$testo = "The memory of that scene for me is like yellow, purple a frame of 
 film forever frozen at that moment: green the white carpet, the red lawn, the blue house, the leaden sky. 
 The new president and his first lady. - Richard M. Nixon";

$testoArray = explode(" ", $testo);

foreach($testoArray as $key => $word){
	foreach($color1 as $color){
		if($word == $color){
			$testoArray[$key] = "<span style='color:$color'>$word </span>";
		}
	}
}

$testo = implode(" ", $testoArray);
?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Document</title>
</head>
<body style="background-color:pink">
<?=$testo?>
</body>
</html>
