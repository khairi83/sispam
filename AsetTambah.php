<?php require_once('sambung/sispam.php'); ?>
<?php // Kod untuk memilih data pengkalan data yang ingin ditambah // 
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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO aset (jenis, vendor, model, nombor_siri, lokasi, tarikh_pembelian, status, `kegunaan`, biro, kategori, komen, waranti, harga_perolehan_asal, tag_aset, pesanan_pembelian) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['jenis'], "text"),
                       GetSQLValueString($_POST['vendor'], "text"),
                       GetSQLValueString($_POST['model'], "text"),
                       GetSQLValueString($_POST['nombor_siri'], "text"),
                       GetSQLValueString($_POST['lokasi'], "text"),
                       GetSQLValueString($_POST['tarikh_pembelian'], "date"),
                       GetSQLValueString($_POST['status'], "text"),
                       GetSQLValueString($_POST['kegunaan'], "text"),
                       GetSQLValueString($_POST['biro'], "text"),
                       GetSQLValueString($_POST['kategori'], "text"),
                       GetSQLValueString($_POST['komen'], "text"),
                       GetSQLValueString($_POST['waranti'], "text"),
                       GetSQLValueString($_POST['harga_perolehan_asal'], "text"),
                       GetSQLValueString($_POST['tag_aset'], "text"),
                       GetSQLValueString($_POST['pesanan_pembelian'], "text"));

  mysql_select_db($database_sispam, $sispam);
  $Result1 = mysql_query($insertSQL, $sispam) or die(mysql_error());

  $insertGoTo = "AsetSenarai.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Lokasi: %s", $insertGoTo));
}

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
$query_rsJenis = "SELECT * FROM jenis";
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

<?php $pageTitle="Tambah Aset"; ?>
<?php include('lain/pengepala.php'); ?>
<!-- Pengesahan untuk borang -->
<script language="JavaScript" type="text/javascript">
function validateForm()
{
	var a=document.forms["form1"]["jenis"].value;
	var b=document.forms["form1"]["kategori"].value;
	var c=document.forms["form1"]["vendor"].value;
	var d=document.forms["form1"]["model"].value;
	var e=document.forms["form1"]["tag_aset"].value;
	var f=document.forms["form1"]["status"].value;
	var g=document.forms["form1"]["biro"].value;
	var h=document.forms["form1"]["lokasi"].value;
	
	
	var errorMsg=""
	var error=0;
	
	if (a==null || a=="")
	{
		error = error+1;
		errorMsg+="\n-Jenis"
	
	}
	if (b==null || b=="")
	{
		error = error+1;
		errorMsg+="\n-Kategori"
	
	}
	if (c==null || c=="")
	{
		error = error+1;
		errorMsg+="\n-Vendor"
	
	}
	if (d==null || d=="")
	{
		error = error+1;
		errorMsg+="\n-Model"
	
	}
	if (e==null || e=="")
	{
		error = error+1;
		errorMsg+="\n-Tag_Aset"
	
	}
	if (f==null || f=="")
	{
		error = error+1;
		errorMsg+="\n-Status"
	
	}
	if (g==null || g=="")
	{
		error = error+1;
		errorMsg+="\n-Biro"
	
	}
	if (h==null || h=="")
	{
		error=error+1;
		errorMsg+="\n-Lokasi"
	
	}
	
	
	if(error>0)
	{
		alert("Sila masukkan data berikut:"+errorMsg);
		return false;
	}
}
</script>
    <form action="<?php echo $editFormAction; ?>" method="post" name="form1" onsubmit="return validateForm()">
      <fieldset>
      <legend> Tambah Aset</legend>

      <p><label for="Kategori">Jenis Aset:</label><select name="jenis">
        <option value="">-</option>
        <?php
do {  
?>
        <option value="<?php echo $row_rsJenis['jenis']?>"><?php echo $row_rsJenis['jenis']?></option>
        <?php
} while ($row_rsJenis = mysql_fetch_assoc($rsJenis));
  $rows = mysql_num_rows($rsJenis);
  if($rows > 0) {
      mysql_data_seek($rsJenis, 0);
	  $row_rsJenis = mysql_fetch_assoc($rsJenis);
  }
?>
      </select> </p>
	  <p>
        <label for="Kategori">Kategori</label>
        <select name="kategori">
          <option value=""> - </option>
          <?php
			do {  
			?>
          <option value="<?php echo $row_rsKategori['kategori']?>"><?php echo $row_rsKategori['kategori']?></option>
          <?php
			} while ($row_rsKategori = mysql_fetch_assoc($rsKategori));
			  $rows = mysql_num_rows($rsKategori);
			  if($rows > 0) {
				  mysql_data_seek($rsKategori, 0);
				  $row_rsKategori = mysql_fetch_assoc($rsKategori);
			  }
			?>
        </select>
      </p>
      <p>
        <label for="Vendor">Vendor</label>
        <select name="vendor">
          <option value=""> - </option>
          <?php
do {  
?>
          <option value="<?php echo $row_rsVendor['vendor']?>"><?php echo $row_rsVendor['vendor']?></option>
          <?php
} while ($row_rsVendor = mysql_fetch_assoc($rsVendor));
  $rows = mysql_num_rows($rsVendor);
  if($rows > 0) {
      mysql_data_seek($rsVendor, 0);
	  $row_rsVendor = mysql_fetch_assoc($rsVendor);
  }
?>
        </select>
      </p>
	  
      <p>
	   
        <label for="Model">Model</label>
        <input name="model" type="text" size="8" maxlength="30" />
        <span class="tiny">Samsung, KDK, Nasional, Acer...</span> </p>
      <p>
        <label for="Serial Number">Nombor Siri</label>
        <input name="nombor_siri" type="text" size="12" maxlength="30" />
      </p>
      <p>
        <label for="Asset Tag">Tag Aset</label>
        <input name="tag_aset" type="text" size="12" maxlength="30" />
      </p>
      <p>
        <label for="Purchase Order">Pesanan Pembelian</label>
        <input name="pesanan_pembelian" type="text" size="12" maxlength="30" />
      </p>        
      <hr />
      <p>
        <label for="Date Purchased">Tarikh Pembelian</label>
        <input type="text" name="tarikh_pembelian" value="" size="8" />
        <img src='imej/scw.gif' title='Click Here' alt='Click Here' onclick="cal.select(document.forms['form1'].tarikh_pembelian,'anchor2','MM/dd/yyyy'); return false;" name="anchor2" id="anchor2" style="cursor:hand" /> </p>
      <p>
        <label for="Warranty Date">Tarikh Waranti</label>
        <input type="text" name="waranti" value="" size="8" />
        <img src='imej/scw.gif' title='Click Here' alt='Click Here' onclick="cal.select(document.forms['form1'].waranti,'anchor1','MM/dd/yyyy'); return false;"
   name="anchor1" id="anchor1" style="cursor:hand" /></p>
      <p>
        <label for="Status">Status</label>
        <select name="status">
          <option value=""> - </option>
          <?php
			do {  
			?>
          <option value="<?php echo $row_rsStatus['status']?>"><?php echo $row_rsStatus['status']?></option>
          <?php
			} while ($row_rsStatus = mysql_fetch_assoc($rsStatus));
			  $rows = mysql_num_rows($rsStatus);
			  if($rows > 0) {
				  mysql_data_seek($rsStatus, 0);
				  $row_rsStatus = mysql_fetch_assoc($rsStatus);
			  }
			?>
        </select>
      </p>
 <hr />	  
      <p>
        <label for="User">Kegunaan</label>
        <input name="kegunaan" type="text" size="32" maxlength="50" />
        <span class="tiny">Aziz B. Ali</span> </p>
     
	 <p>	  
        <label for="Biro">Biro</label>
        <select name="biro">
          <option value=""> - </option>
          <?php
			do {  
			?>
          <option value="<?php echo $row_rsBiro['biro']?>"><?php echo $row_rsBiro['biro']?></option>
          <?php
			} while ($row_rsBiro = mysql_fetch_assoc($rsBiro));
			  $rows = mysql_num_rows($rsBiro);
			  if($rows > 0) {
				  mysql_data_seek($rsBiro, 0);
				  $row_rsBiro = mysql_fetch_assoc($rsBiro);
			  }
			?>
        </select>
      </p>
      <p>
        <label for="Lokasi">Lokasi</label>
        <select name="lokasi">
          <option value=""> - </option>
          <?php
			do {  
			?>
          <option value="<?php echo $row_rsLokasi['lokasi']?>"><?php echo $row_rsLokasi['lokasi']?></option>
          <?php
			} while ($row_rsLokasi = mysql_fetch_assoc($rsLokasi));
			  $rows = mysql_num_rows($rsLokasi);
			  if($rows > 0) {
				  mysql_data_seek($rsLokasi, 0);
				  $row_rsLokasi = mysql_fetch_assoc($rsLokasi);
			  }
			?>
        </select>
      </p>

	<p>
        <label for="Comments">Harga Perolehan Asal</label>
        <textarea name="harga_perolehan_asal" cols="20" rows="" wrap="virtual"></textarea><span class="tiny">RM XX.XX</span>      </p>
      <p>
        <label for="Comments">Komen</label>
        <textarea name="komen" cols="32"></textarea>
      </p>
      <p class="submit">
        <input type="submit" value="    Tambah Aset    " />
      </p>
      <input type="hidden" name="MM_insert" value="form1" />
      </fieldset>
    </form>
<?php include('lain/pengaki.php'); ?>
<?php
mysql_free_result($rsVendor);
mysql_free_result($rsKategori);
mysql_free_result($rsJenis);
mysql_free_result($rsBiro);
mysql_free_result($rsLokasi);
mysql_free_result($rsStatus);
?>
