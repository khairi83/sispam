<?php require_once('sambung/sispam.php'); ?>
<?php // Kemaskini Lokasi // 
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;

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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE lokasi SET lokasi=%s, komen=%s WHERE id=%s",
                       GetSQLValueString($_POST['lokasi'], "text"),
                       GetSQLValueString($_POST['komen'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_sispam, $sispam);
  $Result1 = mysql_query($updateSQL, $sispam) or die(mysql_error());

  $updateGoTo = "LokasiSenarai.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_rsSenaraiLokasi = "-1";
if (isset($_GET['recordID'])) {
  $colname_rsSenaraiLokasi = (get_magic_quotes_gpc()) ? $_GET['recordID'] : addslashes($_GET['recordID']);
}
mysql_select_db($database_sispam, $sispam);
$query_rsSenaraiLokasi = sprintf("SELECT * FROM lokasi WHERE id = %s", $colname_rsSenaraiLokasi);
$rsSenaraiLokasi = mysql_query($query_rsSenaraiLokasi, $sispam) or die(mysql_error());
$row_rsSenaraiLokasi = mysql_fetch_assoc($rsSenaraiLokasi);
$totalRows_rsSenaraiLokasi = mysql_num_rows($rsSenaraiLokasi);
 ?>
<?php $pageTitle="Kemaskini Lokasi"; ?>
<?php include('lain/pengepala.php'); ?>
    <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
      <fieldset>
      <legend>Kemaskini Lokasi</legend>
      <p>
        <label for="Vendor ID">ID Lokasi</label>
        <?php echo $row_rsSenaraiLokasi['id']; ?></p>
      <p>
        <label for="Vendor">Lokasi</label>
        <input type="text" name="lokasi" value="<?php echo $row_rsSenaraiLokasi['lokasi']; ?>" size="32">
      </p>
      <p>
        <label for="Komen">Komen</label>
        <textarea name="komen" cols="30" rows="3"><?php echo $row_rsSenaraiLokasi['komen']; ?></textarea>
      </p>
      <p class="submit">
        <input type="submit" value="Kemaskini Rekod">
      </p>
      </fieldset>
      <input type="hidden" name="MM_update" value="form1">
      <input type="hidden" name="id" value="<?php echo $row_rsSenaraiLokasi['id']; ?>">
    </form>
    <?php include('lain/pengaki.php'); ?>
<?php
mysql_free_result($rsSenaraiLokasi);
?>
