<?php require_once('sambung/sispam.php'); ?>
<?php // Enterprise Asset Management - Graham Fisk - BigSmallweb.com - 2012 // 
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
  $updateSQL = sprintf("UPDATE kategori SET kategori=%s, komen=%s WHERE kategori_id=%s",
                       GetSQLValueString($_POST['kategori'], "text"),
                       GetSQLValueString($_POST['komen'], "text"),
                       GetSQLValueString($_POST['kategori_id'], "int"));

  mysql_select_db($database_sispam, $sispam);
  $Result1 = mysql_query($updateSQL, $sispam) or die(mysql_error());

  $updateGoTo = "KategoriSenarai.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_rsKemaskiniKategori = "-1";
if (isset($_GET['kategori_id'])) {
  $colname_rsKemaskiniKategori = $_GET['kategori_id'];
}
mysql_select_db($database_sispam, $sispam);
$query_rsKemaskiniKategori = sprintf("SELECT * FROM kategori WHERE kategori_id = %s", GetSQLValueString($colname_rsKemaskiniKategori, "int"));
$rsKemaskiniKategori = mysql_query($query_rsKemaskiniKategori, $sispam) or die(mysql_error());
$row_rsKemaskiniKategori = mysql_fetch_assoc($rsKemaskiniKategori);
$totalRows_rsKemaskiniKategori = mysql_num_rows($rsKemaskiniKategori);
?>
<?php $pageTitle="Update Platform"; ?>
<?php include('lain/pengepala.php'); ?>
    <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
      <fieldset>
      <legend>Kemaskini Kategori</legend>
      <p>
        <label for="Vendor ID">id Kategori</label>
        <?php echo $row_rsKemaskiniKategori['kategori_id']; ?></p>
      <p>
        <label for="Vendor">Kategori</label>
        <input type="text" name="kategori" value="<?php echo $row_rsKemaskiniKategori['kategori']; ?>" size="32">
      </p>
      <p>
        <label for="Komen">Komen</label>
        <textarea name="komen" cols="30" rows="3" id="komen"><?php echo $row_rsKemaskiniKategori['komen']; ?></textarea>
      </p>
      <p class="submit">
        <input type="submit" value="Kemaskini rekod">
      </p>
      </fieldset>
      <input type="hidden" name="MM_update" value="form1">
      <input type="hidden" name="kategori_id" value="<?php echo $row_rsKemaskiniKategori['kategori_id']; ?>">
    </form>
    <?php include('lain/pengaki.php'); ?>
<?php
mysql_free_result($rsKemaskiniKategori);
?>
