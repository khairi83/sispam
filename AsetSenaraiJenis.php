<?php require_once('sambung/sispam.php'); ?>
<?php // Senarai Jenis Aset // 
mysql_select_db($database_sispam, $sispam);
$query_rsJenis = "SELECT * FROM jenis";
$rsJenis = mysql_query($query_rsJenis, $sispam) or die(mysql_error());
$row_rsJenis = mysql_fetch_assoc($rsJenis);
$totalRows_rsJenis = mysql_num_rows($rsJenis);
 ?>
<?php $pageTitle="Senarai Jenis Aset"; ?>
<?php include('lain/pengepala.php'); ?>
<h3>Senarai Jenis Aset </h3>
<table width="600" class="table1">
  <tr>
    <th>Jenis Aset </th>
    <th>Komen</th>
    <th>Kemaskini</th>
    <th>Hapus</th>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_rsJenis['jenis']; ?></td>
      <td><?php echo $row_rsJenis['komen']; ?></td>
      <td><a href="AsetKemaskiniJenis.php?recordID=<?php echo $row_rsJenis['id']; ?>">Kemaskini</a></td>
      <td>
    	<form id="delRecord" name="delRecord" method="post" action="AsetHapusJenis.php?recordID=<?php echo $row_rsJenis['id']; ?>">
           <input name="Submit" type="submit" class="red" value="Hapus Rekod Ini" />
        </form>      
      </td>
    </tr>
    <?php } while ($row_rsJenis = mysql_fetch_assoc($rsJenis)); ?>
</table>
<table class="pagination">
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>  
<?php include('lain/pengaki.php'); ?>
<?php
mysql_free_result($rsJenis);
?>
