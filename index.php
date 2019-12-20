<?php require_once('sambung/sispam.php'); ?>
<?php // Setting untuk Paparan Aset //  
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

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_rsAset = 10;
$pageNum_rsAset = 0;
if (isset($_GET['pageNum_rsAset'])) {
  $pageNum_rsAset = $_GET['pageNum_rsAset'];
}
$startRow_rsAset = $pageNum_rsAset * $maxRows_rsAset;

mysql_select_db($database_sispam, $sispam);
$query_rsAset = "SELECT COUNT(*) FROM aset";
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

$maxRows_rsKira = 10;
$pageNum_rsKira = 0;
if (isset($_GET['pageNum_rsKira'])) {
  $pageNum_rsKira = $_GET['pageNum_rsKira'];
}
$startRow_rsKira = $pageNum_rsKira * $maxRows_rsKira;
//Pilih dari Aset dari lokasi
mysql_select_db($database_sispam, $sispam);
$query_rsKira = "SELECT aset.lokasi, COUNT(*) FROM aset GROUP BY aset.lokasi";
$query_limit_rsKira = sprintf("%s LIMIT %d, %d", $query_rsKira, $startRow_rsKira, $maxRows_rsKira);
$rsKira = mysql_query($query_limit_rsKira, $sispam) or die(mysql_error());
$row_rsKira = mysql_fetch_assoc($rsKira);

if (isset($_GET['totalRows_rsKira'])) {
  $totalRows_rsKira = $_GET['totalRows_rsKira'];
} else {
  $all_rsKira = mysql_query($query_rsKira);
  $totalRows_rsKira = mysql_num_rows($all_rsKira);
}
$totalPages_rsKira = ceil($totalRows_rsKira/$maxRows_rsKira)-1;

mysql_select_db($database_sispam, $sispam);
$query_rsNamaMasjid = "SELECT masjid_nama FROM nama_masjid";
$rsNamaMasjid = mysql_query($query_rsNamaMasjid, $sispam) or die(mysql_error());
$row_rsNamaMasjid = mysql_fetch_assoc($rsNamaMasjid);
$totalRows_rsNamaMasjid = mysql_num_rows($rsNamaMasjid);

$queryString_rsKira = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_rsKira") == false && 
        stristr($param, "totalRows_rsKira") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_rsKira = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_rsKira = sprintf("&totalRows_rsKira=%d%s", $totalRows_rsKira, $queryString_rsKira);
 $pageTitle="Laman Utama"; ?>
<?php include('lain/pengepala.php'); ?> 
    <h3> <?php echo $row_rsNamaMasjid['masjid_nama']; ?> - Halaman Utama</h3>
   <table class="tableHome">
      <tr>
        <th width="25%" nowrap="nowrap">Status Semasa</th>
		<th width="25%" nowrap="nowrap">Laporan <span class="tiny">- output CSV </span></th>
      </tr>
      <tr>
  <!-- Kolum yang pertama -->
  <td valign="top" nowrap="nowrap" class="tableNav">
        <ul>
		<form action="CariHasil.php" method="post" name="supportform" id="supportform">
            <script language="JavaScript" type="text/javascript">
			<!--
			function getsupport ( selectedtype )
			{
			  document.supportform.lokasi.value = selectedtype ;
			  document.supportform.submit() ;
			}
			-->
			</script>
            <input type="hidden" name="lokasi" />
            
           
        <li><a href="AsetSenarai.php"> Aset : <?php echo trim($row_rsAset['COUNT(*)']); ?></a></li>
          <?php do { ?>
            <li><a href="javascript:getsupport('<?php echo $row_rsKira['lokasi']; ?>')"><?php echo $row_rsKira['lokasi']; ?> : <?php echo $row_rsKira['COUNT(*)']; ?></a></li>
            <?php } while ($row_rsKira = mysql_fetch_assoc($rsKira)); ?>
         
		 </form> 
		  </ul>
        
</td>
    
<!-- Kolum yang kedua -->
			<td valign="top" class="tableNav">
          <ul>
            <li><a href="LaporanBilikAzan.php">Bilik Azan</a></li>
            <li><a href="LaporanBilikImam.php">Bilik Imam</a></li>
            <li><a href="LaporanDapur.php">Dapur</a></li>
            <li><a href="LaporanDewanSolatLuar.php">Dewan Solat Luar</a></li>
            <li><a href="LaporanDewanSolatUtama.php">Dewan Solat Utama</a></li>
            <li><a href="LaporanDewanSolatWanita.php">Dewan Solat Wanita</a></li>
            <li><a href="LaporanHalamanLuar.php">Halaman Luar</a></li>
			<li><a href="LaporanPejabat.php">Pejabat</a></li>
			<li><a href="LaporanStor.php">Stor</a></li>
          </ul>
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
mysql_free_result($rsAset);
mysql_free_result($rsKira);
mysql_free_result($rsNamaMasjid);
?>
