<?php require_once('sambung/sispam.php'); ?>
<?php // Senarai Pengguna // 
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

$maxRows_rsPengguna = 50;
$pageNum_rsPengguna = 0;
if (isset($_GET['pageNum_rsPengguna'])) {
  $pageNum_rsPengguna = $_GET['pageNum_rsPengguna'];
}
$startRow_rsPengguna = $pageNum_rsPengguna * $maxRows_rsPengguna;

mysql_select_db($database_sispam, $sispam);
$query_rsPengguna = "SELECT * FROM pengguna";
$query_limit_rsPengguna = sprintf("%s LIMIT %d, %d", $query_rsPengguna, $startRow_rsPengguna, $maxRows_rsPengguna);
$rsPengguna = mysql_query($query_limit_rsPengguna, $sispam) or die(mysql_error());
$row_rsPengguna = mysql_fetch_assoc($rsPengguna);

if (isset($_GET['totalRows_rsPengguna'])) {
  $totalRows_rsPengguna = $_GET['totalRows_rsPengguna'];
} else {
  $all_rsPengguna = mysql_query($query_rsPengguna);
  $totalRows_rsPengguna = mysql_num_rows($all_rsPengguna);
}
$totalPages_rsPengguna = ceil($totalRows_rsPengguna/$maxRows_rsPengguna)-1;
?>
<?php include('lain/pengepala.php'); ?>
<h3>Senarai Pengguna</h3>
<table class="table1">
  <tr>
    <th>Nama Penuh</th>
    <th>Jawatan</th>    
    <th>Nama Pengguna</th>
    <th>Peranan</th>
    <th>Kemaskini</th>    
    <th>Hapus</th>    
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_rsPengguna['nama_penuh']; ?></td>
      <td><?php echo $row_rsPengguna['jawatan']; ?></td>
      <td><?php echo $row_rsPengguna['nama_pengguna']; ?></td>
      <td><?php echo $row_rsPengguna['peranan']; ?></td>
      <td><a href="PenggunaKemaskini.php?recordID=<?php echo $row_rsPengguna['id']; ?>">Kemaskini</a></td>
      <td><a href="PenggunaHapus.php?recordID=<?php echo $row_rsPengguna['id']; ?>">Hapus</a></td>
    </tr>
    <?php } while ($row_rsPengguna = mysql_fetch_assoc($rsPengguna)); ?>
</table>
    <table class="pagination">
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table>
<?php include('lain/pengaki.php'); ?>
<?php
mysql_free_result($rsPengguna);
?>
