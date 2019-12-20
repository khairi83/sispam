<?php require_once('sambung/sispam.php'); ?>
<?php // Kod untuk memilih data pengkalan data yang ingin dicari guna menu pilihan // 

mysql_select_db($database_sispam, $sispam);
$query_rsLokasi = "SELECT * FROM lokasi ORDER BY lokasi ASC";
$rsLokasi = mysql_query($query_rsLokasi, $sispam) or die(mysql_error());
$row_rsLokasi = mysql_fetch_assoc($rsLokasi);
$totalRows_rsLokasi = mysql_num_rows($rsLokasi);

mysql_select_db($database_sispam, $sispam);
$query_rsBiro = "SELECT * FROM biro ORDER BY biro ASC";
$rsBiro = mysql_query($query_rsBiro, $sispam) or die(mysql_error());
$row_rsBiro = mysql_fetch_assoc($rsBiro);
$totalRows_rsBiro = mysql_num_rows($rsBiro);

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
$query_rsAset = "SELECT DISTINCT model FROM aset ORDER BY model ASC";
$rsAset = mysql_query($query_rsAset, $sispam) or die(mysql_error());
$row_rsAset = mysql_fetch_assoc($rsAset);
$totalRows_rsAset = mysql_num_rows($rsAset);
$pageTitle="Carian"; ?>
<?php include('lain/pengepala.php'); ?>
<fieldset>
<legend>Carian Aset</legend>
<form id="searchAset" name="searchAset" method="post" action="CariHasil.php">
  <table class="tableSearch">
	
	<!-- cari  lokasi-->
	<tr>
	<th>Lokasi</th>
	  <td>
        <select name="lokasi" id="lokasi">
          <option value="value">Pilih Lokasi</option>
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
        </select></td>
	  <td>
        <input type="submit" name="Submit" value="Cari" />      </td>
	  </tr>
	<!-- cari  Biro-->
	<tr>
	<th>Biro</th>
	  <td>
        <select name="biro" id="biro">
          <option value="value">Pilih Biro</option>
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
        </select></td>
	  <td>
        <input type="submit" name="Submit" value="Cari" />      </td>
	  </tr>
	<!-- cari  Vendor-->
	<tr>
      <th>Vendor</th>
	  <td>
        <select name="vendor" id="vendor">
          <option value="value">Pilih Vendor</option>
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
        </select></td>
	  <td>
        <input type="submit" name="Submit" value="Cari" />      </td>
	  </tr>
	  <!-- cari  Model-->
	<tr>
	  <th>Model </th>
	  <td>
	    <select name="model" id="model">
		<option value="value">Pilih Model</option>
	      <?php
do {  
?>
	      <option value="<?php echo $row_rsAset['model']?>"><?php echo $row_rsAset['model']?></option>
	      <?php
} while ($row_rsAset = mysql_fetch_assoc($rsAset));
  $rows = mysql_num_rows($rsAset);
  if($rows > 0) {
      mysql_data_seek($rsAset, 0);
	  $row_rsAset = mysql_fetch_assoc($rsAset);
  }
?>
	      </select></td>
	  <td>
	    <input type="submit" name="Submit" value="Cari" /></td>
	  </tr>
	  <!-- cari  Kategori-->
	<tr>
	  <th>Kategori </th>
	  <td>
	    <select name="kategori" id="kategori">
		  <option value="">Pilih Kategori</option>
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
		  </select>	  </td>
	  <td>
	    <input type="submit" name="Submit" value="Cari" />	  </td>
	</tr>
	<!-- cari  Jenis Aset-->
	<tr>
	  <th>Jenis Aset</th>
	  <td>
	    <select name="jenis" id="jenis">
		  <option value="">Pilih Jenis Aset </option>
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
		  </select>	</td>
	  <td>
	    <input type="submit" name="Submit" value="Cari" />	  </td>
	</tr>
	<!-- cari  Kegunaan-->
	<tr>
      <th>Kegunaan</th>
	  <td>
        <input type="text" name="kegunaan" />      </td>
	  <td>
        <input type="submit" name="Submit" value="Cari" />      </td>
	  </tr>
	  <!-- cari  Purchase Order-->
	  <tr>
	  <th>Pesanan Pembelian</th>
	  <td><input type="text" name="pesanan_pembelian" /></td>
	  <td><input type="submit" name="Submit" value="Cari" /></td>
	  </tr>
	  <!-- cari  Tag Aset-->
	<tr>
	  <th>Tag Aset</th>
	  <td><input type="text" name="tag_aset" /></td>
	  <td><input type="submit" name="Submit" value="Cari" /></td>
	  </tr>
	  <!-- cari  Nombor Siri-->
	<tr>
	  <th>Nombor Siri</th>
	  <td>
	    <input type="text" name="nombor_siri" />	  </td>
	  <td>
	    <input type="submit" name="Submit" value="Cari" />	  </td>
	</tr>
	<tr>

  </table>
</form>
</fieldset>
<?php include('lain/pengaki.php'); ?>
<?php
mysql_free_result($rsLokasi);
mysql_free_result($rsBiro);
mysql_free_result($rsVendor);
mysql_free_result($rsKategori);
mysql_free_result($rsJenis);
mysql_free_result($rsAset);
?>
