<?php require_once('sambung/sispam.php'); ?>
<?php // Kemaskini Pengguna // 
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE pengguna SET nama_pengguna=%s, katalaluan=%s, nama_penuh=%s, jawatan=%s, `peranan`=%s WHERE id=%s",
                       GetSQLValueString($_POST['nama_pengguna'], "text"),
                       GetSQLValueString($_POST['katalaluan'], "text"),
                       GetSQLValueString($_POST['nama_penuh'], "text"),
                       GetSQLValueString($_POST['jawatan'], "text"),
                       GetSQLValueString($_POST['peranan'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_sispam, $sispam);
  $Result1 = mysql_query($updateSQL, $sispam) or die(mysql_error());

  $updateGoTo = "PenggunaSenarai.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_rsPengguna = "-1";
if (isset($_GET['recordID'])) {
  $colname_rsPengguna = $_GET['recordID'];
}
mysql_select_db($database_sispam, $sispam);
$query_rsPengguna = sprintf("SELECT * FROM pengguna WHERE id = %s", GetSQLValueString($colname_rsPengguna, "int"));
$rsPengguna = mysql_query($query_rsPengguna, $sispam) or die(mysql_error());
$row_rsPengguna = mysql_fetch_assoc($rsPengguna);
$totalRows_rsPengguna = mysql_num_rows($rsPengguna);

mysql_select_db($database_sispam, $sispam);
$query_rsPerananPengguna = "SELECT `peranan` FROM pengguna";
$rsPerananPengguna = mysql_query($query_rsPerananPengguna, $sispam) or die(mysql_error());
$row_rsPerananPengguna = mysql_fetch_assoc($rsPerananPengguna);
$totalRows_rsPerananPengguna = mysql_num_rows($rsPerananPengguna);

mysql_free_result($rsPengguna);

mysql_free_result($rsPerananPengguna);

$pageTitle="Kemaskini Pengguna"; ?>
<?php include('lain/pengepala.php'); ?>

<form method="post" name="form1" action="<?php echo $editFormAction; ?>">

  
  
  <fieldset>
      <legend>Kemaskini Pengguna</legend>
      <p>
        <label for="Vendor ID">ID Pengguna</label>
        <?php echo $row_rsPengguna['id']; ?></p>
      <p>
        <label for="First Name">Nama Penuh</label>
        <input type="text" name="nama_penuh" value="<?php echo htmlentities($row_rsPengguna['nama_penuh'], ENT_COMPAT, ''); ?>" size="32">
      </p>
      <p>
        <label for="Last Name">Jawatan</label>
        <input type="text" name="jawatan" value="<?php echo htmlentities($row_rsPengguna['jawatan'], ENT_COMPAT, ''); ?>" size="32">
      </p>
      <p>
        <label for="Nama_pengguna">Nama Pengguna</label>
        <input type="text" name="nama_pengguna" value="<?php echo htmlentities($row_rsPengguna['nama_pengguna'], ENT_COMPAT, ''); ?>" size="32">
      </p>
      <p>
        <label for="Katalaluan">Katalaluan</label>
        <input type="text" name="katalaluan" value="<?php echo htmlentities($row_rsPengguna['katalaluan'], ENT_COMPAT, ''); ?>" size="32">
      </p>
      <p>
        <label for="Role">Peranan</label>
        <select name="peranan">
          <option value="pengurus" <?php if (!(strcmp("pengurus", $row_rsPengguna['peranan']))) {echo "selected=\"selected\"";} ?>>Pengurus - Kebenaran Penuh</option>
          <option value="operator" <?php if (!(strcmp("operator", $row_rsPengguna['peranan']))) {echo "selected=\"selected\"";} ?>>Operator - Mengurus Aset, Laporan</option>
          <?php
do {  
?>
<option value="<?php echo $row_rsPengguna['peranan']?>"<?php if (!(strcmp($row_rsPengguna['peranan'], $row_rsPengguna['peranan']))) {echo "selected=\"selected\"";} ?>><?php echo $row_rsPengguna['peranan']?> &nbsp;&nbsp;<- peranan sekarang</option>
          <?php
} while ($row_rsPerananPengguna = mysql_fetch_assoc($rsPerananPengguna));
  $rows = mysql_num_rows($rsPerananPengguna);
  if($rows > 0) {
      mysql_data_seek($rsPerananPengguna, 0);
	  $row_rsPerananPengguna = mysql_fetch_assoc($rsPerananPengguna);
  }
?>
        </select>
      </p>
   
      <p class="submit">
        <input type="submit" value="Kemaskini Pengguna">
      </p>
      </fieldset>  
  
  
  <input type="hidden" name="MM_update" value="form1">
  <input type="hidden" name="id" value="<?php echo $row_rsPengguna['id']; ?>">
</form>
    <?php include('lain/pengaki.php'); ?><?php
mysql_free_result($rsSoftwareVendor);
?>
