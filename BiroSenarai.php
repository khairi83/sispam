<?php require_once('sambung/sispam.php'); ?>
<?php // Senarai Biro // 
mysql_select_db($database_sispam, $sispam);
$query_rsSenaraiBiro = "SELECT * FROM biro";
$rsSenaraiBiro = mysql_query($query_rsSenaraiBiro, $sispam) or die(mysql_error());
$row_rsSenaraiBiro = mysql_fetch_assoc($rsSenaraiBiro);
$totalRows_rsSenaraiBiro = mysql_num_rows($rsSenaraiBiro);
?>
<?php 
	$pageTitle="Biro";
	include('lain/pengepala.php');
?>
<h3>Senarai Biro</h3>

<table width="600" class="table1">
  <tr>
    <th>Biro</th>
    <th>komen</th>
    <th>Kemaskini</th>
    <th>Hapus</th>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_rsSenaraiBiro['biro']; ?></td>
      <td><?php echo $row_rsSenaraiBiro['komen']; ?></td>
      <td><a href="BiroKemaskini.php?recordID=<?php echo $row_rsSenaraiBiro['id']; ?>">Kemaskini</a></td>
      <td>
    	<form id="delRecord" name="delRecord" method="post" action="BiroHapus.php?recordID=<?php echo $row_rsSenaraiBiro['id']; ?>">
           <input name="Submit" type="submit" class="red" value="Hapus Rekod Ini" />
        </form>      
      </td>
    </tr>
    <?php } while ($row_rsSenaraiBiro = mysql_fetch_assoc($rsSenaraiBiro)); ?>
</table>
<table class="pagination">
  <tr>
    <td>&nbsp;</td>
  </tr>
</table> 

<?php include('lain/pengaki.php'); ?>
<?php
mysql_free_result($rsSenaraiBiro);
?>
