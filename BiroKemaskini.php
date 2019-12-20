<?php require_once('sambung/sispam.php'); ?>
<?php // Kemaskini Biro // 
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
  $updateSQL = sprintf("UPDATE biro SET biro=%s, komen=%s WHERE id=%s",
                       GetSQLValueString($_POST['biro'], "text"),
                       GetSQLValueString($_POST['komen'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_sispam, $sispam);
  $Result1 = mysql_query($updateSQL, $sispam) or die(mysql_error());

  $updateGoTo = "BiroSenarai.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_rsKemaskiniBiro = "-1";
if (isset($_GET['recordID'])) {
  $colname_rsKemaskiniBiro = (get_magic_quotes_gpc()) ? $_GET['recordID'] : addslashes($_GET['recordID']);
}
mysql_select_db($database_sispam, $sispam);
$query_rsKemaskiniBiro = sprintf("SELECT * FROM biro WHERE id = %s", $colname_rsKemaskiniBiro);
$rsKemaskiniBiro = mysql_query($query_rsKemaskiniBiro, $sispam) or die(mysql_error());
$row_rsKemaskiniBiro = mysql_fetch_assoc($rsKemaskiniBiro);
$totalRows_rsKemaskiniBiro = mysql_num_rows($rsKemaskiniBiro);
?>
<?php $pageTitle="Kemaskini Biro"; ?>
<?php include('lain/pengepala.php'); ?>
    <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
      <fieldset>
      <legend>Kemaskini Biro</legend>
      <p>
        <label for="Vendor ID">ID Biro</label>
        <?php echo $row_rsKemaskiniBiro['id']; ?></p>
      <p>
        <label for="Vendor">Biro</label>
        <input type="text" name="biro" value="<?php echo $row_rsKemaskiniBiro['biro']; ?>" size="32" />
      </p>
      <p>
        <label for="Komen">Komen</label>
        <textarea name="komen" cols="30" rows="3"><?php echo $row_rsKemaskiniBiro['komen']; ?></textarea>
      </p>
      <p class="submit">
        <input type="submit" value="Kemaskini rekod">
      </p>
      </fieldset>
      <input type="hidden" name="MM_update" value="form1">
      <input type="hidden" name="id" value="<?php echo $row_rsKemaskiniBiro['id']; ?>">
    </form>
    <?php include('lain/pengaki.php'); ?>
<?php
mysql_free_result($rsKemaskiniBiro);
?>
