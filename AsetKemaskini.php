<?php require_once('sambung/sispam.php'); ?>
<?php // Kod untuk memilih data pengkalan data yang ingin di kemaskini // 
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
  $updateSQL = sprintf("UPDATE aset SET jenis=%s, vendor=%s, model=%s, nombor_siri=%s, lokasi=%s, tarikh_pembelian=%s, tarikh_lupus=%s, status=%s, `kegunaan`=%s, biro=%s, kategori=%s, komen=%s, waranti=%s, harga_perolehan_asal=%s, tag_aset=%s, pesanan_pembelian=%s WHERE aset_id=%s",
                       GetSQLValueString($_POST['jenis'], "text"),
                       GetSQLValueString($_POST['vendor'], "text"),
                       GetSQLValueString($_POST['model'], "text"),
                       GetSQLValueString($_POST['nombor_siri'], "text"),
                       GetSQLValueString($_POST['lokasi'], "text"),
                       GetSQLValueString($_POST['tarikh_pembelian'], "text"),
                       GetSQLValueString($_POST['tarikh_lupus'], "text"),
                       GetSQLValueString($_POST['status'], "text"),
                       GetSQLValueString($_POST['kegunaan'], "text"),
                       GetSQLValueString($_POST['biro'], "text"),
                       GetSQLValueString($_POST['kategori'], "text"),
                       GetSQLValueString($_POST['komen'], "text"),
                       GetSQLValueString($_POST['waranti'], "text"),
                       GetSQLValueString($_POST['harga_perolehan_asal'], "text"),
                       GetSQLValueString($_POST['tag_aset'], "text"),
                       GetSQLValueString($_POST['pesanan_pembelian'], "text"),
                       GetSQLValueString($_POST['aset_id'], "int"));

  mysql_select_db($database_sispam, $sispam);
  $Result1 = mysql_query($updateSQL, $sispam) or die(mysql_error());

  $updateGoTo = "AsetSenarai.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Lokasi: %s", $updateGoTo));
}

$colname_rsKemaskini = "-1";
if (isset($_GET['recordID'])) {
  $colname_rsKemaskini = $_GET['recordID'];
}
mysql_select_db($database_sispam, $sispam);
$query_rsKemaskini = sprintf("SELECT * FROM aset WHERE aset_id = %s", GetSQLValueString($colname_rsKemaskini, "int"));
$rsKemaskini = mysql_query($query_rsKemaskini, $sispam) or die(mysql_error());
$row_rsKemaskini = mysql_fetch_assoc($rsKemaskini);
$totalRows_rsKemaskini = mysql_num_rows($rsKemaskini);

mysql_select_db($database_sispam, $sispam);
$query_rsVendor = "SELECT * FROM vendor ORDER BY vendor ASC";
$rsVendor = mysql_query($query_rsVendor, $sispam) or die(mysql_error());
$row_rsVendor = mysql_fetch_assoc($rsVendor);
$totalRows_rsVendor = mysql_num_rows($rsVendor);

mysql_select_db($database_sispam, $sispam);
$query_rsKategori = "SELECT * FROM kategori ORDER BY kategori ASC";
$rsKategori = mysql_query($query_rsKategori, $sispam) or die(mysql_error());
$row_rsKategori = mysql_fetch_assoc($rsKategori);
$totalRows_rsKategori = mysql_num_rows($rsKategori);

mysql_select_db($database_sispam, $sispam);
$query_rsJenis = "SELECT * FROM jenis ORDER BY jenis ASC";
$rsJenis = mysql_query($query_rsJenis, $sispam) or die(mysql_error());
$row_rsJenis = mysql_fetch_assoc($rsJenis);
$totalRows_rsJenis = mysql_num_rows($rsJenis);

mysql_select_db($database_sispam, $sispam);
$query_rsBiro = "SELECT * FROM biro ORDER BY biro ASC";
$rsBiro = mysql_query($query_rsBiro, $sispam) or die(mysql_error());
$row_rsBiro = mysql_fetch_assoc($rsBiro);
$totalRows_rsBiro = mysql_num_rows($rsBiro);

mysql_select_db($database_sispam, $sispam);
$query_rsLokasi = "SELECT * FROM lokasi ORDER BY lokasi ASC";
$rsLokasi = mysql_query($query_rsLokasi, $sispam) or die(mysql_error());
$row_rsLokasi = mysql_fetch_assoc($rsLokasi);
$totalRows_rsLokasi = mysql_num_rows($rsLokasi);

mysql_select_db($database_sispam, $sispam);
$query_rsStatus = "SELECT * FROM status ORDER BY status ASC";
$rsStatus = mysql_query($query_rsStatus, $sispam) or die(mysql_error());
$row_rsStatus = mysql_fetch_assoc($rsStatus);
$totalRows_rsStatus = mysql_num_rows($rsStatus);

?>
<?php $pageTitle="Update Hardware Asset"; ?>
<?php include('lain/pengepala.php'); ?>
    <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
      <fieldset>
      <legend>Aset - Kemaskini</legend>
      <!--	<p>
	<label for="Asset Id ">Asset Id </label>
	<?php echo $row_rsKemaskini['aset_id']; ?>
	</p> -->
      <p>
        <label for="Asset Type">Jenis Aset</label>
        <select name="jenis">
          <?php 
		do {  
		?>
          <option value="<?php echo $row_rsJenis['jenis']?>" <?php if (!(strcmp($row_rsJenis['jenis'], $row_rsKemaskini['jenis']))) {echo "SELECTED";} ?>><?php echo $row_rsJenis['jenis']?></option>
          <?php
} while ($row_rsJenis = mysql_fetch_assoc($rsJenis));
?>
        </select>
      </p>
	  

      <p>
        <label for="Platform">Kategori</label>
        <select name="kategori">
          <?php 
do {  
?>
          <option value="<?php echo $row_rsKategori['kategori']?>" <?php if (!(strcmp($row_rsKategori['kategori'], $row_rsKemaskini['kategori']))) {echo "SELECTED";} ?>><?php echo $row_rsKategori['kategori']?></option>
          <?php
} while ($row_rsKategori = mysql_fetch_assoc($rsKategori));
?>
        </select>
      </p>
      <p>
        <label for="Vendor">Vendor</label>
        <select name="vendor">
          <?php 
do {  
?>
          <option value="<?php echo $row_rsVendor['vendor']?>" <?php if (!(strcmp($row_rsVendor['vendor'], $row_rsKemaskini['vendor']))) {echo "SELECTED";} ?>><?php echo $row_rsVendor['vendor']?></option>
          <?php
} while ($row_rsVendor = mysql_fetch_assoc($rsVendor));
?>
        </select>
      </p>
      <p>
        <label for="Model">Model</label>
        <input name="model" type="text" value="<?php echo $row_rsKemaskini['model']; ?>" size="8" maxlength="30" /> 
		<span class="tiny">Samsung, KDK, Nasional, Acer..</span> 
      </p>
      <p>
        <label for="Serial number">Nombor Siri</label>
        <input name="nombor_siri" type="text" value="<?php echo $row_rsKemaskini['nombor_siri']; ?>" size="12" maxlength="30" />
      </p>
      <p>
        <label for="Asset Tag">Tag Aset</label>
        <input name="tag_aset" type="text" value="<?php echo $row_rsKemaskini['tag_aset']; ?>" size="12" maxlength="30" />
      </p>
      <p>
        <label for="Asset Tag">Pesanan Pembelian</label>
        <input name="pesanan_pembelian" type="text" value="<?php echo $row_rsKemaskini['pesanan_pembelian']; ?>" size="12" maxlength="30" />
      </p>           
      <hr />
      <p>
        <label for="Status">Status</label>
        <select name="status">
          <?php 
do {  
?>
          <option value="<?php echo $row_rsStatus['status']?>" <?php if (!(strcmp($row_rsStatus['status'], $row_rsKemaskini['status']))) {echo "SELECTED";} ?>><?php echo $row_rsStatus['status']?></option>
          <?php
} while ($row_rsStatus = mysql_fetch_assoc($rsStatus));
?>
        </select>
      </p>
      <p>
        <label for="Date purchased">Tarikh Pembelian</label>
        <input type="text" name="tarikh_pembelian" value="<?php echo $row_rsKemaskini['tarikh_pembelian']; ?>" size="8" />
        <img src='imej/scw.gif' title='Click Here' alt='Click Here' onclick="cal.select(document.forms['form1'].tarikh_pembelian,'anchor2','MM/dd/yyyy'); return false;" name="anchor2" id="anchor2" style="cursor:hand" /> </p>
      <p>
        <label for="Warrant Date ">Tarikh Waranti </label>
        <input type="text" name="waranti" value="<?php echo $row_rsKemaskini['waranti']; ?>" size="8" />
        <img src='imej/scw.gif' title='Click Here' alt='Click Here' onclick="cal.select(document.forms['form1'].waranti,'anchor1','MM/dd/yyyy'); return false;" name="anchor1" id="anchor1" style="cursor:hand" /> </p>
      <p>
        <label for="Biro">Tarikh Lupus</label>
        <input type="text" name="tarikh_lupus" value="<?php echo $row_rsKemaskini['tarikh_lupus']; ?>" size="8" />
        <img src='imej/scw.gif' title='Click Here' alt='Click Here' onclick="cal.select(document.forms['form1'].tarikh_lupus,'anchor3','MM/dd/yyyy'); return false;" name="anchor3" id="anchor3" style="cursor:hand" /> </p>
      <hr />
      <p>
        <label for="User">Kegunaan</label>
        <input name="kegunaan" type="text" value="<?php echo $row_rsKemaskini['kegunaan']; ?>" size="32" maxlength="50" />
        <span class="tiny">Aziz B. Ali</span> </p>
      <p>
        <label for="Biro">Biro</label>
        <select name="biro">
          <?php 
do {  
?>
          <option value="<?php echo $row_rsBiro['biro']?>" <?php if (!(strcmp($row_rsBiro['biro'], $row_rsKemaskini['biro']))) {echo "SELECTED";} ?>><?php echo $row_rsBiro['biro']?></option>
          <?php
} while ($row_rsBiro = mysql_fetch_assoc($rsBiro));
?>
        </select
	>
      </p>
      <p>
        <label for="Lokasi">Lokasi</label>
        <select name="lokasi">
          <?php 
do {  
?>
          <option value="<?php echo $row_rsLokasi['lokasi']?>" <?php if (!(strcmp($row_rsLokasi['lokasi'], $row_rsKemaskini['lokasi']))) {echo "SELECTED";} ?>><?php echo $row_rsLokasi['lokasi']?></option>
          <?php
} while ($row_rsLokasi = mysql_fetch_assoc($rsLokasi));
?>
        </select>
      </p>
      <p>
        <label for="Biro">Harga Perolehan Asal</label>
        <textarea name="harga_perolehan_asal" cols="20" rows="3" wrap="physical"><?php echo $row_rsKemaskini['harga_perolehan_asal']; ?></textarea>
        <span class="tiny">RM xx.xx</span> </p>
      <p>
        <label for="Biro">Komen</label>
        <textarea name="komen" cols="30" rows="3"><?php echo $row_rsKemaskini['komen']; ?></textarea>
      </p>
      <p class="submit">
        <input type="submit" value="Kemaskini rekod" />
      </p>
      </fieldset>
      <input type="hidden" name="MM_update" value="form1">
      <input type="hidden" name="aset_id" value="<?php echo $row_rsKemaskini['aset_id']; ?>">
    </form>
    <?php include('lain/pengaki.php'); ?>
<?php
mysql_free_result($rsKemaskini);

mysql_free_result($rsVendor);

mysql_free_result($rsKategori);

mysql_free_result($rsJenis);

mysql_free_result($rsBiro);

mysql_free_result($rsLokasi);

mysql_free_result($rsStatus);

?>
