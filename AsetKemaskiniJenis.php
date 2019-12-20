<?php require_once('sambung/sispam.php'); ?>
<?php // Kemaskini Jenis Aset // 
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
  $updateSQL = sprintf("UPDATE jenis SET jenis=%s, komen=%s WHERE id=%s",
                       GetSQLValueString($_POST['jenis'], "text"),
                       GetSQLValueString($_POST['komen'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_sispam, $sispam);
  $Result1 = mysql_query($updateSQL, $sispam) or die(mysql_error());

  $updateGoTo = "AsetSenaraiJenis.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_rsJenis = "-1";
if (isset($_GET['recordID'])) {
  $colname_rsJenis = $_GET['recordID'];
}
mysql_select_db($database_sispam, $sispam);
$query_rsJenis = sprintf("SELECT * FROM jenis WHERE id = %s", GetSQLValueString($colname_rsJenis, "int"));
$rsJenis = mysql_query($query_rsJenis, $sispam) or die(mysql_error());
$row_rsJenis = mysql_fetch_assoc($rsJenis);
$totalRows_rsJenis = mysql_num_rows($rsJenis);
 
$pageTitle="Kemaskini Jenis Aset"; ?>
<?php include('lain/pengepala.php'); ?>

    <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
      <fieldset>
      <legend>Kemaskini Jenis Aset </legend>
      <p>
        <label for="Vendor ID">ID Jenis Aset</label>
        <?php echo $row_rsJenis['id']; ?></p>
      <p>
        <label for="Vendor">Jenis Aset</label>
        <input type="text" name="jenis" value="<?php echo $row_rsJenis['jenis']; ?>" size="32">
      </p>
      <p>
        <label for="Komen">Komen</label>
        <textarea name="komen" cols="30" rows="3"><?php echo $row_rsJenis['komen']; ?></textarea>
      </p>
      <p class="submit">
        <input type="submit" value="Kemaskini rekod">
      </p>
      </fieldset>
      <input type="hidden" name="MM_update" value="form1">
      <input type="hidden" name="id" value="<?php echo $row_rsJenis['id']; ?>">
    </form>

    <?php include('lain/pengaki.php'); ?>
<?php
mysql_free_result($rsJenis);
?>
