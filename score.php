<?php
include('database.php');
require "auth.php";
require "header.php";
if($_SESSION['session']== 1) { //Buh
  ?>
  <!DOCTYPE html>
  <html>
  <head>
  <title>Нет доступа</title>
  <meta charset="utf-8">
  <link rel="stylesheet" href="/css/style.css">
  </head>
  <body>
<h1 align="center" style="color:#358A1E;text-shadow: yellow 0 0 10px;">"Доступ Закрыт, Обратитесь к администратору"</h1>
  <?php
  require "footer.php";
  ?>
  </body>
  </html>
  <?php
} else {
?>
<!DOCTYPE html>
<html>
<head>
<title>JMM HelpDesk</title>
<meta charset="utf-8">
<link rel="stylesheet" href="/css/style.css">
</head>
<body>
<div>
  <?php
if(isset($_GET['del']) !=0 )
{
  $sqldel = "DELETE FROM score WHERE id=".$_GET['del'];
  $resdel=mysqli_query($link, $sqldel);
    if (!$resdel) {
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $sqldel;
    die($message);
  } else {
  }
}
?>
<h1 align="center" style="color:#358A1E;text-shadow: yellow 0 0 10px;">💰 Регулярные платежи</h1>
<?php
echo "<a href='score-add.php'style='position:relative;left:9%;top:36px;' class='button' >Добавить</a></br></br>";
$qy ="SELECT MAX(type) AS type FROM score";
$rt = mysqli_query($link, $qy);

while ($line = mysqli_fetch_assoc($rt)) {
    foreach ($line as $col_value) {
    }
  }

for ($i=1; $i <= $col_value ; $i++) {
$query ="SELECT * FROM score where `type`=$i";
   $result = mysqli_query($link, $query);
$q2 = mysqli_query($link, "SELECT * FROM scoretype WHERE `id` =$i");
$sp2=mysqli_fetch_array($q2);
echo "<table style='margin-left:140px' width='80%' class='simple-little-table'>";
$num=0;
echo "<tr><th width='4%'>#</th><th width='30%'>Провайдер</th><th width='20%'>Договор</th><th width='10%'>Год\Месяц</th><th width='10%'>Сумма</th><th  width='4%' style='font-size:13pt'>✘</th></tr>";

echo "<h1 align='center' style='color:#358A1E;text-shadow: yellow 0 0 10px;'>$sp2[name]</h1>";
for ($c1=1; $c1<=mysqli_num_rows($result); $c1++) {
$row = mysqli_fetch_array($result);
$id=$row['id'];
$type=$row['type'];
$num++;
echo "<tr><td>$num</td><td><a href='score-edit.php?id=$row[id]'>$row[provider]</a></td><td>$row[dogovor]</td><td>$row[mesec]</td><td>$row[count]</td><td style='font-size:13pt'><a href='javascript:confirmDelete($row[id]);'>✘</a></td></tr>";
}
}
echo "</table>";
?>
</div>
</div>
<script type="text/javascript">
function confirmDelete(id) {
if (confirm("Вы подтверждаете удаление?")) {
  document.location.href = 'score.php?del=' +id;
} else {
  document.location = 'score.php';
}
}
</script>
<?php
require "footer.php";
?>
</body>
</html>
<?php
}
?>
