<?php require_once('sambung/sispam.php'); ?>
<?php // Hapus Aset // 
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

if ((isset($_GET['recordID'])) && ($_GET['recordID'] != "")) {
  $deleteSQL = sprintf("DELETE FROM biro WHERE id=%s",
                       GetSQLValueString($_GET['recordID'], "int"));

  mysql_select_db($database_sispam, $sispam);
  $Result1 = mysql_query($deleteSQL, $sispam) or die(mysql_error());

  $deleteGoTo = "BiroSenarai.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
}
 
$pageTitle="Hapus Biro"; ?>
<?php include('lain/pengepala.php'); ?>
    <h3>Hapus Biro </h3>
    <form id="delRecord" name="delRecord" method="post" action="">
      <input type="submit" name="Submit" value="Hapus rekod" />
    </form>
    <?php include('lain/pengaki.php'); ?>
