<?php require_once('sambung/sispam.php'); ?>
<?php // Kod untuk memilih data pengkalan data yang ingin disenarai // 
$currentPage = $_SERVER["PHP_SELF"];

$maxRows_rsAset = 50;
$pageNum_rsAset = 0;
if (isset($_GET['pageNum_rsAset'])) {
  $pageNum_rsAset = $_GET['pageNum_rsAset'];
}
$startRow_rsAset = $pageNum_rsAset * $maxRows_rsAset;

mysql_select_db($database_sispam, $sispam);
$query_rsAset = "SELECT * FROM aset";
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

mysql_select_db($database_sispam, $sispam);
$query_rsVendor = "SELECT * FROM vendor";
$rsVendor = mysql_query($query_rsVendor, $sispam) or die(mysql_error());
$row_rsVendor = mysql_fetch_assoc($rsVendor);
$totalRows_rsVendor = mysql_num_rows($rsVendor);

mysql_select_db($database_sispam, $sispam);
$query_rsKategori = "SELECT * FROM kategori";
$rsKategori = mysql_query($query_rsKategori, $sispam) or die(mysql_error());
$row_rsKategori = mysql_fetch_assoc($rsKategori);
$totalRows_rsKategori = mysql_num_rows($rsKategori);

$colname_rsKemaskini = "-1";
if (isset($_GET['recordID'])) {
  $colname_rsKemaskini = (get_magic_quotes_gpc()) ? $_GET['recordID'] : addslashes($_GET['recordID']);
}
mysql_select_db($database_sispam, $sispam);
$query_rsKemaskini = sprintf("SELECT * FROM aset WHERE aset_id = %s", $colname_rsKemaskini);
$rsKemaskini = mysql_query($query_rsKemaskini, $sispam) or die(mysql_error());
$row_rsKemaskini = mysql_fetch_assoc($rsKemaskini);
$totalRows_rsKemaskini = mysql_num_rows($rsKemaskini);

mysql_select_db($database_sispam, $sispam);
$query_rsBiro = "SELECT * FROM biro";
$rsBiro = mysql_query($query_rsBiro, $sispam) or die(mysql_error());
$row_rsBiro = mysql_fetch_assoc($rsBiro);
$totalRows_rsBiro = mysql_num_rows($rsBiro);

mysql_select_db($database_sispam, $sispam);
$query_rsJenis = "SELECT * FROM jenis";
$rsJenis = mysql_query($query_rsJenis, $sispam) or die(mysql_error());
$row_rsJenis = mysql_fetch_assoc($rsJenis);
$totalRows_rsJenis = mysql_num_rows($rsJenis);

mysql_select_db($database_sispam, $sispam);
$query_rsLokasi = "SELECT * FROM lokasi";
$rsLokasi = mysql_query($query_rsLokasi, $sispam) or die(mysql_error());
$row_rsLokasi = mysql_fetch_assoc($rsLokasi);
$totalRows_rsLokasi = mysql_num_rows($rsLokasi);

mysql_select_db($database_sispam, $sispam);
$query_rsStatus = "SELECT * FROM status";
$rsStatus = mysql_query($query_rsStatus, $sispam) or die(mysql_error());
$row_rsStatus = mysql_fetch_assoc($rsStatus);
$totalRows_rsStatus = mysql_num_rows($rsStatus);

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
$queryString_rsAset = sprintf("&totalRows_rsAset=%d%s", $totalRows_rsAset, $queryString_rsAset); ?>
<?php $pageTitle="Senarai Aset"; ?>
<?php include('lain/pengepala.php'); ?>
    <h3>Senarai Aset </h3>
    <table class="table1">
      <tr>
        <th>Jenis Aset</th>
        <th>Vendor</th>
        <th>Model</th>
        <th>Kategori</th>
        <th>Lokasi</th>
        <th>Status</th>
        <th>Kegunaan</th>
        <th>Biro</th>
        <th>Lihat &nbsp; </th>
        <th>Edit &nbsp; </th>
      </tr>
      <?php do { ?>
        <tr onmouseover="this.bgColor='#F2F7FF'" onmouseout="this.bgColor='#FFFFFF'";>
          <td> <?php echo $row_rsAset['jenis']; ?>&nbsp; </td>
          <td> <?php echo $row_rsAset['vendor']; ?>&nbsp; </td>
          <td> <?php echo $row_rsAset['model']; ?>&nbsp; </td>
          <td> <?php echo $row_rsAset['kategori']; ?>&nbsp; </td>
          <td> <?php echo $row_rsAset['lokasi']; ?>&nbsp; </td>
          <td> <?php echo $row_rsAset['status']; ?>&nbsp; </td>
          <td> <?php echo $row_rsAset['kegunaan']; ?>&nbsp; </td>
          <td> <?php echo $row_rsAset['biro']; ?>&nbsp; </td>
          <td> <a href="AsetTerperinci.php?recordID=<?php echo $row_rsAset['aset_id']; ?>">Lihat</a></td>
          <td> <a href="AsetKemaskini.php?recordID=<?php echo $row_rsAset['aset_id']; ?>">Edit</a></td>
        </tr>
      <?php } while ($row_rsAset = mysql_fetch_assoc($rsAset)); ?>
    </table>
<!-- <table class="pagination">
      <tr>
	  <td>Records <?php echo ($startRow_rsAset + 1) ?> to <?php echo min($startRow_rsAset + $maxRows_rsAset, $totalRows_rsAset) ?> of <?php echo $totalRows_rsAset ?></td>
	  <td>
	  <table>
	  <tr>
	  <?php if ($pageNum_rsAset > 0) { // Tunjukkan jika tidak muka pertama ?>
        <td width="23%" align="center">
            <a href="<?php printf("%s?pageNum_rsAset=%d%s", $currentPage, 0, $queryString_rsAset); ?>">First</a>
        </td>
		<?php } // Tunjukkan jika tidak muka pertama ?>

 		<?php if ($pageNum_rsAset > 0) { // Tunjukkan jika tidak muka pertama ?>		
        <td width="31%" align="center">
            <a href="<?php printf("%s?pageNum_rsAset=%d%s", $currentPage, max(0, $pageNum_rsAset - 1), $queryString_rsAset); ?>">Previous</a>
         </td>
		 <?php } // Tunjukkan jika tidak muka pertama ?>
        
		
         <?php if ($pageNum_rsAset < $totalPages_rsAset) { // Tunjukkan jika tidak muka terakhir ?>
        <td width="23%" align="center">
            <a href="<?php printf("%s?pageNum_rsAset=%d%s", $currentPage, min($totalPages_rsAset, $pageNum_rsAset + 1), $queryString_rsAset); ?>">Next</a>
         </td>
		 <?php } // Tunjukkan jika tidak muka terakhir ?>
        
		<?php if ($pageNum_rsAset < $totalPages_rsAset) { // Tunjukkan jika tidak muka terakhir ?>
        <td width="23%" align="center">
            <a href="<?php printf("%s?pageNum_rsAset=%d%s", $currentPage, $totalPages_rsAset, $queryString_rsAset); ?>">Last</a> 
        </td>
		<?php } // Tunjukkan jika tidak muka terakhir ?>		
      </tr>
    </table>
	</td>
	</tr>
	</table>
   -->
  
  
<table class="pagination">
<tr>
  <td><div style="float:left;">Rekod <?php echo ($startRow_rsAset + 1) ?> hingga <?php echo min($startRow_rsAset + $maxRows_rsAset, $totalRows_rsAset) ?> dari <?php echo $totalRows_rsAset ?></div>
  <div style="float:right;">
    <table class="pagination1">
      <tr>
        <?php if ($pageNum_rsAset > 0) { // Tunjukkan jika tidak muka pertama ?>
          <td> <a href="<?php printf("%s?pageNum_rsAset=%d%s", $currentPage, 0, $queryString_rsAset); ?>"><img src="imej/Pertama.gif" alt="First Page" title="Halaman Pertama" /></a> </td>
            <?php } // Tunjukkan jika tidak muka pertama ?>
        
          <td> <a href="<?php printf("%s?pageNum_rsAset=%d%s", $currentPage, max(0, $pageNum_rsAset - 1), $queryString_rsAset); ?>"><img src="imej/Sebelum.gif" alt="Previous Page" title="Halaman Sebelumnya" /></a> </td>
            
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

mysql_free_result($rsVendor);

mysql_free_result($rsKategori);

mysql_free_result($rsKemaskini);

mysql_free_result($rsBiro);

mysql_free_result($rsJenis);

mysql_free_result($rsLokasi);

mysql_free_result($rsStatus);
?>