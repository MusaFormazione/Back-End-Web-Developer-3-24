<?php
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>DatiDaForm</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
<!--<pre>-->
<!--	--><?php //print_r($_SERVER); ?>
<!--</pre>-->
<a href="<?=$_SERVER['PHP_SELF']?>">Vai a PHP_SELF</a>

<? if ($_SERVER['REQUEST_METHOD'] == 'POST') : ?>
<p class="post-method">POST</p>
<pre>
	<?php print_r($_POST); ?>
</pre>
	Files:

<? if (is_uploaded_file($_FILES['my-file']['tmp_name'])): ?>
<p>File caricato</p>
<pre>
	<?php print_r($_FILES); ?>
</pre>
	<? move_uploaded_file($_FILES['my-file']['tmp_name'], 'uploads/' . $_FILES['my-file']['name']); ?>
<? endif ?>

<? else: ?>
<p class="get-method">GET</p>
<pre>
	<?php print_r($_GET); ?>
</pre>

<? endif ?>

<h4>Headers</h4>
<pre>
	<?php print_r(getAllHeaders()); ?>
</pre>


<form action="<?=$_SERVER['PHP_SELF']?>" enctype="multipart/form-data" method="POST">
	<input type="hidden" name="my-key" value="my-value">
	<select name="my-select">
		<option value="1">1</option>
		<option value="2">2</option>
		<option value="3">3</option>
	</select>
	<select name="my-select-multiple[]" multiple>
		<option value="1">1</option>
		<option value="2">2</option>
		<option value="3">3</option>
	</select>
	<input type="text" name="my-text">
	<input type="checkbox" name="my-checkbox">
	<input type="checkbox" name="my-checkbox-multiple[]" value="1">
	<input type="checkbox" name="my-checkbox-multiple[]" value="2">
	<input type="checkbox" name="my-checkbox-multiple[]" value="3">
	<input type="checkbox" name="my-checkbox-multiple[]" value="4">
	<input type="radio" name="my-radio">
	<input type="file" name="my-file">
	<input type="submit" value="Invia POST">
</form>

<form action="<?=$_SERVER['PHP_SELF']?>" method="GET">
	<input type="hidden" name="my-key" value="my-value">
	<input type="submit" value="Invia GET">
</form>
</body>
</html>
