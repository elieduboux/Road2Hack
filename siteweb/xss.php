<html>
<head> 
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta charset="utf-8"> 
	<link rel="stylesheet" href="stylesheet.css">
<title>Super Injection</title>
</head>
<body background="mtn.png" height=100% width=100%> </body>
<title>Super Cross-Site Scripting</title>
<form action="./xss.php" method='post'>
 <label for="message">Poster un message sur le site :</label>
 <input type="text" id=message name=message>
 <input type="submit" value="Submit">
</form>
<form action=./xss.php method='post'>
 <label for="clean">Nettoyer les messages :</label>
 <input type="hidden" name="clean" value="Clean !">
 <input type="submit" value="Clean !">
</form>
</html>
<?php
$conn = mysqli_connect('database', 'root', 'tiger', 'docker');


if (mysqli_connect_error()) {
   print("<br>Connection to Mysql Database failed: " . mysqli_connect_error());
   exit();
}

$data = $_POST["message"];
$clean = $_POST["clean"];
$id = 2;

if ($data != "") {
	$query = "INSERT INTO posts VALUES (" . $id . ",'" . $data . "');";
	mysqli_query($conn, $query);
}

if ($clean != "") {
	$query = "DELETE FROM posts;";
	mysqli_query($conn, $query);
	echo "database cleaned !";
}

//

$query = "SELECT id_user, content FROM posts;";
$result = mysqli_query($conn, $query);
echo "<br><h4>Messages :</h4>";
if ($result->num_rows > 0) {
	echo "<table><tr><td>id</td><td>message</td></tr>";
	echo "<tr><td> </td><td> </td></tr><tr><td> </td><td> </td></tr><tr><td> </td><td> </td></tr>";
	while($row = $result->fetch_assoc()) {
		echo"<tr><td>" . $row["id_user"] . "</td><td>" . $row["content"] . "</td></tr>";
	}
	echo "</table>";
} else {
	echo "<br>Be the first to post a message here !";
}

$conn->close();
?>
