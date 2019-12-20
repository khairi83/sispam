<?php require_once('sambung/sispam.php'); ?>
<?php // Enterprise Asset Management - Graham Fisk - BigSmallweb.com - 2012 // 
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
$query_rsSenaraiKategori = "SELECT * FROM kategori";
$rsSenaraiKategori = mysql_query($query_rsSenaraiKategori, $sispam) or die(mysql_error());
$row_rsSenaraiKategori = mysql_fetch_assoc($rsSenaraiKategori);
$totalRows_rsSenaraiKategori = mysql_num_rows($rsSenaraiKategori);
?><?php $pageTitle="Kategori"; ?>
<?php include('lain/pengepala.php'); ?>
<h3>Senarai Kategori</h3>
<table width="600" cellspacing="0" class="table1">
  <tr>
    <th>Kategori</th>
    <th>Komen</th>
    <th>Kemaskini</th>
    <th>Hapus</th>
  </tr>
  <?php do { ?>
  <tr>
    <td><?php echo $row_rsSenaraiKategori['kategori']; ?></td>
    <td><?php echo $row_rsSenaraiKategori['komen']; ?></td>
    <td><a href="KategoriKemaskini.php?kategori_id=<?php echo $row_rsSenaraiKategori['kategori_id']; ?>">Kemaskini</a></td>
    <td>
    	<form id="delRecord" name="delRecord" method="post" action="KategoriHapus.php?recordID=<?php echo $row_rsSenaraiKategori['kategori_id']; ?>">
           <input name="Submit" type="submit" class="red" value="Hapus Rekod Ini" />
        </form>
    </td>
  </tr>
  <?php } while ($row_rsSenaraiKategori = mysql_fetch_assoc($rsSenaraiKategori)); ?>
</table>
<table class="pagination">
  <tr>
    <td>&nbsp;</td>
  </tr>
</table> 
<?php include('lain/pengaki.php'); ?>
<?php
mysql_free_result($rsSenaraiKategori);
?>
