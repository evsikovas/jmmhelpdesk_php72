<?php
  $db_host='127.0.0.1';
  $db_name='jetop';
  $db_user='jmmconnect';
  $db_pass='JmmCon13';
#  @mysql_connect($sdd_db_host,$sdd_db_user,$sdd_db_pass);
#  @mysql_select_db($sdd_db_name);
$link = mysqli_connect($db_host,$db_user,$db_pass,$db_name);
mysqli_query($link, "SET NAMES utf8");
?>
