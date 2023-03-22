<html>

</html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta charset="utf-8"> 
  <link rel="stylesheet" href="stylesheet.css">
  <title> Super Login </title>
</head>
<body background="mtn.png" height=100% width=100%>
<h1> ZEN </h1>
<img src="loup.png">
</body>   
  <form action="./index.php" method="get">
    <h2> J'ai enfin une plateforme en ligne ! Venez faire des affaires chez ZEN votre fournisseur de confiance :)</h2>
  <label for="user">Username :</label>
  <input type="text" id="user" name="user"><br><br>
  <label for="pass">Password:</label>
  <input type="text" id="pass" name="pass"><br><br>
  <input type="submit" value="Submit">
</form>
<!-- Carlos, I just made this database. I kept the small backdoor that you made. XOXO -Artemicion-->
</html>

<?php
$name = $_GET['user'];
$pass = $_GET['pass'];

if ($name == "" or $pass == "") {
	exit();
}

if (strpos($name, '=') !== false or strpos($pass, '=')) {
    exit();
}

echo "Tentative de connection avec utilisateur : " . $name . " et mot de passe : " . $pass;

$conn = mysqli_connect('database', 'root', 'tiger', 'docker');

echo "<br>PHP is responding. <br>Trying to connect to the sql database...";

if (mysqli_connect_error()) {
   print("<br>Connect failed: " . mysqli_connect_error());
   exit();
}

echo "<br>Connection successfull !<hr>";
$query = "SELECT name,password FROM credentials WHERE name='" . $name . "' AND password='" . $pass . "';";
echo "<br> La requête envoyée était : " . $query;

$result = mysqli_query($conn, $query);
echo "<br><h4>Résultat :</h4>";
if ($result->num_rows > 0) {
	echo "<table><tr><td>name</td><td>password</td></tr>";
	echo "<tr><td> </td><td> </td></tr><tr><td> </td><td> </td></tr><tr><td> </td><td> </td></tr>";
	while($row = $result->fetch_assoc()) {
		echo"<tr><td>" . $row["name"] . "</td><td>" . $row["password"] . "</td></tr>";
	}
	echo "</table>";
} else {
	echo "<br>No result.";
}


$conn->close();

?>
