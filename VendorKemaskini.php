<?php require_once('sambung/sispam.php'); ?>
<?php // Kemaskini Vendor // 
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
  $updateSQL = sprintf("UPDATE vendor SET vendor=%s, komen=%s WHERE vendor_id=%s",
                       GetSQLValueString($_POST['vendor'], "text"),
                       GetSQLValueString($_POST['komen'], "text"),
                       GetSQLValueString($_POST['vendor_id'], "int"));

  mysql_select_db($database_sispam, $sispam);
  $Result1 = mysql_query($updateSQL, $sispam) or die(mysql_error());

  $updateGoTo = "VendorSenarai.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_rsKemaskiniVendor = "-1";
if (isset($_GET['vendor_id'])) {
  $colname_rsKemaskiniVendor = (get_magic_quotes_gpc()) ? $_GET['vendor_id'] : addslashes($_GET['vendor_id']);
}
mysql_select_db($database_sispam, $sispam);
$query_rsKemaskiniVendor = sprintf("SELECT * FROM vendor WHERE vendor_id = %s", $colname_rsKemaskiniVendor);
$rsKemaskiniVendor = mysql_query($query_rsKemaskiniVendor, $sispam) or die(mysql_error());
$row_rsKemaskiniVendor = mysql_fetch_assoc($rsKemaskiniVendor);
$totalRows_rsKemaskiniVendor = mysql_num_rows($rsKemaskiniVendor);
?>
<?php $pageTitle="Kemaskini Vendor"; ?>
<?php include('lain/pengepala.php'); ?>
    <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
      <fieldset>
      <legend>Kemaskini Vendor</legend>
      <p>
        <label for="Vendor ID">id Vendor </label>
        <?php echo $row_rsKemaskiniVendor['vendor_id']; ?> </p>
      <p>
        <label for="Vendor">Vendor</label>
        <input value="<?php echo $row_rsKemaskiniVendor['vendor']; ?>" name="vendor" type="text" id="vendor" />
      </p>
      <p>
        <label for="Komen">Komen</label>
        <textarea name="komen" cols="30" rows="3"><?php echo $row_rsKemaskiniVendor['komen']; ?></textarea>
      </p>
      <p class="submit">
        <input type="submit" value="Kemaskini rekod">
      </p>
      </fieldset>
      <input type="hidden" name="MM_update" value="form1">
      <input type="hidden" name="vendor_id" value="<?php echo $row_rsKemaskiniVendor['vendor_id']; ?>">
    </form>
    <?php include('lain/pengaki.php'); ?>
<?php
mysql_free_result($rsKemaskiniVendor);
?>
