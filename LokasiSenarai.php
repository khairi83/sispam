<?php require_once('sambung/sispam.php'); ?>
<?php // Senarai Lokasi // 
mysql_select_db($database_sispam, $sispam);
$query_rsSenaraiLokasi = "SELECT * FROM lokasi ORDER BY lokasi ASC";
$rsSenaraiLokasi = mysql_query($query_rsSenaraiLokasi, $sispam) or die(mysql_error());
$row_rsSenaraiLokasi = mysql_fetch_assoc($rsSenaraiLokasi);
$totalRows_rsSenaraiLokasi = mysql_num_rows($rsSenaraiLokasi);
?>
<?php $pageTitle="Lokasi"; ?>
<?php include('lain/pengepala.php'); ?>
    <h3>Senarai Lokasi</h3>
    <table width="600" class="table1">
      <tr>
        <th>Lokasi</th>
        <th>Komen</th>
        <th>Kemaskini</th>
        <th>Hapus</th>
      </tr>
      <?php do { ?>
        <tr>
          <td><?php echo $row_rsSenaraiLokasi['lokasi']; ?></td>
          <td><?php echo $row_rsSenaraiLokasi['komen']; ?></td>
          <td><a href="LokasiKemaskini.php?recordID=<?php echo $row_rsSenaraiLokasi['id']; ?>">Kemaskini</a></td>
          <td>
    	<form id="delRecord" name="delRecord" method="post" action="LokasiHapus.php?recordID=<?php echo $row_rsSenaraiLokasi['id']; ?>">
           <input name="Submit" type="submit" class="red" value="Hapus Rekod Ini" />
        </form>              
          </td>
        </tr>
      <?php } while ($row_rsSenaraiLokasi = mysql_fetch_assoc($rsSenaraiLokasi)); ?>
    </table>
<table class="pagination">
  <tr>
    <td>&nbsp;</td>
  </tr>
</table> 

<?php include('lain/pengaki.php'); ?>
<?php
mysql_free_result($rsSenaraiLokasi);
?>
