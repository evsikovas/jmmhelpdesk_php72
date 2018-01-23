<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="/css/style.css">
</head>
<body style="background-image:none">
<button onclick='window.location.reload(true)' class="button" style="position:relative;left:39%;">Refrash</button>
<?php 
 header('Content-Type: text/html; charset=cp866');
include('database.php');
mysqli_real_escape_string($link, $_GET["id"]);
$id = isset($_GET['id']) ? $_GET['id'] : '';
$query = "SELECT * FROM oplist WHERE id = $id";
$result = mysqli_query($link, $query) or die($query."<br/><br/>".mysql_error());
$myrow = mysqli_fetch_assoc($result);
$ip = $myrow['ip'];
ob_implicit_flush(true);
ob_end_flush();
echo '<pre>';
system('ping '.$ip.'');
echo '</pre>';
?>
</body>
</html>