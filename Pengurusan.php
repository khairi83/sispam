<?php require_once('sambung/sispam.php'); ?>
<?php // Pengurusan // 
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "pengurus";
$MM_donotCheckaccess = "false";

// *** Hadkan Akses ke laman: Pemberian atau menafikan Akses ke laman ini
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // Untuk keselamatan, mulakan dengan menganggap pengunjung TIDAK dibenarkan. 
  $isValid = False; 

  // Apabila seorang pengunjung telah log masuk ke dalam laman web ini, Sesi MM_Username pembolehubah ditetapkan sama dengan nama pengguna mereka. 
  // Oleh itu, kita tahu bahawa pengguna adalah TIDAK melog masuk jika nilai pembolehubah Sesi kosong. 
  if (!empty($UserName)) { 
    // Selain log masuk, anda boleh menyekat Akses kepada hanya pengguna-pengguna tertentu berdasarkan ID ditubuhkan apabila mereka log masuk. 
    // Mengurai rentetan ke dalam tatasusunan. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Atau, anda boleh menyekat Akses kepada hanya pengguna tertentu berdasarkan nama pengguna mereka. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && false) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "Akses.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($QUERY_STRING) && strlen($QUERY_STRING) > 0) 
  $MM_referrer .= "?" . $QUERY_STRING;
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?><?php
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
 $pageTitle="Admin"; ?>
<?php include('lain/Pengepala_pengurusan.php'); ?>
    <h3> <?php echo $row_rsNamaMasjid['masjid_nama']; ?> - Pengurusan Aset / Pengguna</h3>
    <table class="tableHome">
      <tr>
        <th width="20%" nowrap="nowrap"> Tambah <span class="tiny">- tambah baru </span></th>
        <th width="20%" nowrap="nowrap"> Kemaskini <span class="tiny">- lihat/tukar</span></th>
		<th width="20%" nowrap="nowrap"> Daftar <span class="tiny"></span></th>
      </tr>
      <tr>
        <td valign="top" class="tableNav">
          <ul>
            <li><a href="VendorTambah.php"> Vendor Aset</a></li>
            <li><a href="AsetTambahJenis.php"> Jenis Aset</a></li>
            <li><a href="KategoriTambah.php"> Kategori Aset</a></li>
            <li><a href="#">--</a></li>		
            <li><a href="BiroTambah.php"> Biro <span class="tiny">(Unit biro-biro)</span></a></li>
            <li><a href="LokasiTambah.php"> Lokasi <span class="tiny">(Kawasan Masjid)</span></a></li>
          </ul>        </td>
        <td valign="top" class="tableNav"><ul>
            <li><a href="VendorSenarai.php">Vendor Aset</a></li>
            <li><a href="AsetSenaraiJenis.php">Jenis Aset </a></li>
            <li><a href="KategoriSenarai.php">Kategori Aset</a></li>
            <li><a href="#">--</a></li>            
			<li><a href="BiroSenarai.php">Biro</a></li>
            <li><a href="LokasiSenarai.php">Lokasi</a></li>
            </ul>
            </td>
        <td valign="top" class="tableNav"><ul>
            <li><a href="PenggunaTambah.php"> Pengguna: Tambah Pengguna</a></li>
          <li><a href="PenggunaSenarai.php"> Pengguna: Kemaskini Pengguna </a></li>
          <li><a href="#">--</a></li>
          <li><a href="MasjidKemaskini.php">Nama Masjid - Kemaskini</a></li>
        </ul></td>
      </tr>
    </table>
    <table class="pagination">
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table>     
    <?php include('lain/pengaki.php'); ?>
<?php

?>
