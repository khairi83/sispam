<?php require_once('sambung/sispam.php'); ?>
<?php // Kemaskini Masjid // 
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
  $updateSQL = sprintf("UPDATE nama_masjid SET masjid_nama=%s WHERE masjid_id=%s",
                       GetSQLValueString($_POST['masjid_nama'], "text"),
                       GetSQLValueString($_POST['masjid_id'], "int"));

  mysql_select_db($database_sispam, $sispam);
  $Result1 = mysql_query($updateSQL, $sispam) or die(mysql_error());

  $updateGoTo = "Pengurusan.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

mysql_select_db($database_sispam, $sispam);
$query_rsMasjidUpdate = "SELECT * FROM nama_masjid";
$rsMasjidUpdate = mysql_query($query_rsMasjidUpdate, $sispam) or die(mysql_error());
$row_rsMasjidUpdate = mysql_fetch_assoc($rsMasjidUpdate);
$totalRows_rsMasjidUpdate = mysql_num_rows($rsMasjidUpdate);
?>
<?php include('lain/pengepala.php'); ?>
    <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
      <fieldset>
      <legend>Nama Masjid - Kemaskini</legend>

      <p>
        <label for="Masjid Name">Nama Masjid:</label>
        <input name="masjid_nama" type="text" value="<?php echo htmlentities($row_rsMasjidUpdate['masjid_nama'], ENT_COMPAT, 'iso-8859-1'); ?>" size="32" maxlength="200" />
      <p class="submit">
        <input type="submit" value="Kemaskini rekod" />
      </p>
      <input type="hidden" name="MM_update" value="form1" />
      <input type="hidden" name="masjid_id" value="<?php echo $row_rsMasjidUpdate['masjid_id']; ?>" />


      <p>&nbsp;</p>
      <p>&nbsp;</p>
      </fieldset>
    </form>
    <?php include('lain/pengaki.php'); ?>
<?php
mysql_free_result($rsMasjidUpdate);
?>
