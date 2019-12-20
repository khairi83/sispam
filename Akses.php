<?php require_once('sambung/sispam.php'); ?>
<?php // Akses masuk // 
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

mysql_select_db($database_sispam, $sispam);
$query_rsNamaMasjid = "SELECT masjid_nama FROM nama_masjid";
$rsNamaMasjid = mysql_query($query_rsNamaMasjid, $sispam) or die(mysql_error());
$row_rsNamaMasjid = mysql_fetch_assoc($rsNamaMasjid);
$totalRows_rsNamaMasjid = mysql_num_rows($rsNamaMasjid);
 $pageTitle="Home"; ?>
<?php include('lain/pengepala.php'); ?> 
    <h3><?php //echo $row_rsNamaMasjid['data']; ?> - Sistem Pengurusan Aset Masjid</h3>
    <table class="table1">
      <tr>
        <th width="25%" nowrap="nowrap">Maaf!</th>
      </tr>
      <tr>
        <td>
          <p>&nbsp;</p>
          <p align="center">Anda telah megakses laman yang dihadkan - sila hubungi pengurus untuk meminta akses!</p>
          <p align="center"><a href="index.php">Bawa saya ke laman utama!</a></p>
          <p align="center">&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
        </td>
      </tr>
    </table>
    <table class="pagination">
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table>    
</div>
<?php include('lain/pengaki.php'); ?>
<?php
mysql_free_result($rsNamaMasjid);
?>
