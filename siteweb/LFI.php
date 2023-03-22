<html>
<head> 
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta charset="utf-8"> 
	<link rel="stylesheet" href="stylesheet.css">
<title>Super Local File Inclusion</title>
</head>
<body background="mtn.png" height=100% width=100%> 

</body>

<form action="./LFI.php" type="get">
 <label for="file">test1</label>
 <input type="radio" id="file" name="file" value="test.txt" checked><br>
 <label for="file">test2</label>
 <input type="radio" id="file" name="file" value="test2.txt"><br>
 <label for="file">test3</label>
 <input type="radio" id="file" name="file" value="test3.txt"><br>
 <label for="file">test4</label>
 <input type="radio" id="file" name="file" value="test4.txt"><br><br>
 <input type="submit" valeur="Submit">
</form>
</html>

<?php
$data = $_GET["file"];

if ($data == "") { // no parameter
	exit();
}

$fp = fopen($data, 'r');
$content = fread($fp, filesize($data));

echo $content;
?>
