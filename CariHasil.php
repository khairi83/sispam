<?php require_once('sambung/sispam.php'); ?>
<?php // Setting untuk digunakan dalam Paparan Carian  // 
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
 // Pilih dari Pangkalan data aset // 
$maxRows_rsAset = 50;
$pageNum_rsAset = 0;
if (isset($_GET['pageNum_rsAset'])) {
  $pageNum_rsAset = $_GET['pageNum_rsAset'];
}
$startRow_rsAset = $pageNum_rsAset * $maxRows_rsAset;

$varModel_rsAset = "-1";
if (isset($_POST['model'])) {
  $varModel_rsAset = $_POST['model'];
}
$varKegunaan_rsAset = "-1";
if (isset($_POST['kegunaan'])) {
  $varKegunaan_rsAset = $_POST['kegunaan'];
}
$varKegunaanAccount_rsAset = "-1";
if (isset($_POST['biro'])) {
  $varKegunaanAccount_rsAset = $_POST['biro'];
}
$varLocation_rsAset = "-1";
if (isset($_POST['lokasi'])) {
  $varLocation_rsAset = $_POST['lokasi'];
}
$varNombor_Siri_rsAset = "-1";
if (isset($_POST['nombor_siri'])) {
  $varNombor_Siri_rsAset = $_POST['nombor_siri'];
}
$varAssettype_rsAset = "-1";
if (isset($_POST['jenis'])) {
  $varAssettype_rsAset = $_POST['jenis'];
}
$varVendor_rsAset = "-1";
if (isset($_POST['vendor'])) {
  $varVendor_rsAset = $_POST['vendor'];
}
$varKategori_rsAset = "-1";
if (isset($_POST['kategori'])) {
  $varKategori_rsAset = $_POST['kategori'];
}
$varAssetTag_rsAset = "-1";
if (isset($_POST['tag_aset'])) {
  $varAssetTag_rsAset = $_POST['tag_aset'];
}
$varPurchaseOrder_rsAset = "-1";
if (isset($_POST['pesanan_pembelian'])) {
  $varPurchaseOrder_rsAset = $_POST['pesanan_pembelian'];
}
//Pilihan dari table untuk carian
mysql_select_db($database_sispam, $sispam);
$query_rsAset = sprintf("SELECT * FROM aset WHERE vendor = %s or kategori = %s or jenis = %s or nombor_siri = %s or kegunaan = %s or biro = %s or lokasi = %s or model = %s or tag_aset = %s or pesanan_pembelian = %s ORDER BY aset.`kegunaan`", GetSQLValueString($varVendor_rsAset, "text"),GetSQLValueString($varKategori_rsAset, "text"),GetSQLValueString($varAssettype_rsAset, "text"),GetSQLValueString($varNombor_Siri_rsAset, "text"),GetSQLValueString($varKegunaan_rsAset, "text"),GetSQLValueString($varKegunaanAccount_rsAset, "text"),GetSQLValueString($varLocation_rsAset, "text"),GetSQLValueString($varModel_rsAset, "text"),GetSQLValueString($varAssetTag_rsAset, "text"),GetSQLValueString($varPurchaseOrder_rsAset, "text"));
$query_limit_rsAset = sprintf("%s LIMIT %d, %d", $query_rsAset, $startRow_rsAset, $maxRows_rsAset);
$rsAset = mysql_query($query_limit_rsAset, $sispam) or die(mysql_error());
$row_rsAset = mysql_fetch_assoc($rsAset);

if (isset($_GET['totalRows_rsAset'])) {
  $totalRows_rsAset = $_GET['totalRows_rsAset'];
} else {
  $all_rsAset = mysql_query($query_rsAset);
  $totalRows_rsAset = mysql_num_rows($all_rsAset);
}
$totalPages_rsAset = ceil($totalRows_rsAset/$maxRows_rsAset)-1;

$queryString_rsAset = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_rsAset") == false && 
        stristr($param, "totalRows_rsAset") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_rsAset = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_rsAset = sprintf("&totalRows_rsAset=%d%s", $totalRows_rsAset, $queryString_rsAset);
 
$pageTitle="Carian Aset"; ?>
<?php include('lain/pengepala.php'); ?>
<?php
$currentPage = $_SERVER["PHP_SELF"];
?>
<h3>Aset Carian</h3>
<table class="table1">
  <tr>
    <th>Pesanan Pembelian</th>
    <th>Tag Aset</th>      
    <th>Nombor Siri</th>  
    <th>Vendor</th>
    <th>Kategori</th>	
    <th>Jenis Aset</th>
    <th>Model</th>
    <th>Status</th>	
    <th>Lokasi</th>
    <th>Kegunaan</th>
    <th>Biro</th>	
    <th>Lihat </th>
    <th>Edit</th>
  </tr>
  <?php do { ?>
    <tr onmouseover="this.bgColor='#F2F7FF'" onmouseout="this.bgColor='#FFFFFF'";>
      <td><?php echo $row_rsAset['pesanan_pembelian']; ?></td>
      <td><?php echo $row_rsAset['tag_aset']; ?></td>          
      <td><?php echo $row_rsAset['nombor_siri']; ?></td>    
      <td><?php echo $row_rsAset['vendor']; ?></td>	
      <td><?php echo $row_rsAset['kategori']; ?></td>
      <td><?php echo $row_rsAset['jenis']; ?></td>
      <td><?php echo $row_rsAset['model']; ?></td>
	  <td><?php echo $row_rsAset['status']; ?></td>	  
      <td><?php echo $row_rsAset['lokasi']; ?></td>
      <td><?php echo $row_rsAset['kegunaan']; ?></td>
      <td><?php echo $row_rsAset['biro']; ?></td>
      <td><a href="AsetTerperinci.php?recordID=<?php echo $row_rsAset['aset_id']; ?>">Lihat</a></td>
      <td><a href="AsetKemaskini.php?recordID=<?php echo $row_rsAset['aset_id']; ?>">Edit</a></td>
    </tr>
    <?php } while ($row_rsAset = mysql_fetch_assoc($rsAset)); ?>
</table>
<table class="pagination">
<tr>
  <td><div style="float:left;">Rekod <?php echo ($startRow_rsAset + 1) ?> hingga <?php echo min($startRow_rsAset + $maxRows_rsAset, $totalRows_rsAset) ?> dari <?php echo $totalRows_rsAset ?></div>
  <div style="float:right;">
    <table class="pagination1">
      <tr>
        <?php if ($pageNum_rsAset > 0) { // Tunjukkan jika tidak muka pertama ?>
          <td> <a href="<?php printf("%s?pageNum_rsAset=%d%s", $currentPage, 0, $queryString_rsAset); ?>"><img src="imej/Pertama.gif" alt="First Page" title="Halaman Pertama" /></a> </td>
            <?php } // Tunjukkan jika tidak muka pertama ?>
			
        <?php if ($pageNum_rsAset > 0) { // Tunjukkan jika tidak muka pertama ?>	
          <td> <a href="<?php printf("%s?pageNum_rsAset=%d%s", $currentPage, max(0, $pageNum_rsAset - 1), $queryString_rsAset); ?>"><img src="imej/Sebelum.gif" alt="Previous Page" title="Halaman Sebelumnya" /></a> </td>
         <?php } // Tunjukkan jika tidak muka pertama ?>
		 
        <?php if ($pageNum_rsAset < $totalPages_rsAset) { // Tunjukkan jika tidak muka terakhir ?>
          <td> <a href="<?php printf("%s?pageNum_rsAset=%d%s", $currentPage, min($totalPages_rsAset, $pageNum_rsAset + 1), $queryString_rsAset); ?>"><img src="imej/Seterusnya.gif" alt="Next Page" title="Halaman Seterusnya" /></a> </td>
            <?php } // Tunjukkan jika tidak muka terakhir ?>
        <?php if ($pageNum_rsAset < $totalPages_rsAset) { // Tunjukkan jika tidak muka terakhir ?>
          <td> <a href="<?php printf("%s?pageNum_rsAset=%d%s", $currentPage, $totalPages_rsAset, $queryString_rsAset); ?>"><img src="imej/Terakhir.gif" alt="Last Page" title="Halaman Terakhir" /></a> </td>
            <?php } // Tunjukkan jika tidak muka terakhir ?>
        </tr>
    </table>
	</div>
  </td>
  </tr>
</table>	
  <?php include('lain/pengaki.php'); ?>
<?php
mysql_free_result($rsAset);
?>
