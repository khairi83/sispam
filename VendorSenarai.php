<?php require_once('sambung/sispam.php'); ?>
<?php // Senarai Vendor // 
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

if ((isset($_POST['vendor_id'])) && ($_POST['vendor_id'] != "")) {
  $deleteSQL = sprintf("DELETE FROM vendor WHERE vendor_id=%s",
                       GetSQLValueString($_POST['vendor_id'], "int"));

  mysql_select_db($database_sispam, $sispam);
  $Result1 = mysql_query($deleteSQL, $sispam) or die(mysql_error());

  $deleteGoTo = "SenaraiVendor.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
}

mysql_select_db($database_sispam, $sispam);
$query_rsSenaraiVendor = "SELECT * FROM vendor ORDER BY vendor ASC";
$rsSenaraiVendor = mysql_query($query_rsSenaraiVendor, $sispam) or die(mysql_error());
$row_rsSenaraiVendor = mysql_fetch_assoc($rsSenaraiVendor);
$totalRows_rsSenaraiVendor = mysql_num_rows($rsSenaraiVendor);
?>
<?php $pageTitle="Senarai Vendor"; ?>
<?php include('lain/pengepala.php'); ?>
    <h3>Senarai Vendor </h3>
    <table width="600" class="table1">
      <tr>
        <th>Vendor</th>
        <th>Komen</th>
        <th>Kemaskini</th>
        <th>Hapus</th>
      </tr>
      <?php do { ?>
        <tr>
          <td><?php echo $row_rsSenaraiVendor['vendor']; ?></td>
          <td><?php echo $row_rsSenaraiVendor['komen']; ?></td>
          <td><a href="VendorKemaskini.php?vendor_id=<?php echo $row_rsSenaraiVendor['vendor_id']; ?>">Kemaskini</a></td>
          <td> <form id="delRecord" name="delRecord" method="post" action="VendorHapus.php?recordID=<?php echo $row_rsSenaraiVendor['vendor_id']; ?>">
                  <input name="Submit" type="submit" class="red" value="Hapus Rekod Ini" />
                </form></td>
        </tr>
      <?php } while ($row_rsSenaraiVendor = mysql_fetch_assoc($rsSenaraiVendor)); ?>
    </table>
    <table class="pagination">
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table>      
<?php include('lain/pengaki.php'); ?>
<?php
mysql_free_result($rsSenaraiVendor);
?>
