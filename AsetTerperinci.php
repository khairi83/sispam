<?php require_once('sambung/sispam.php'); ?>
<?php // Kod untuk memilih data pengkalan data yang ingin disenaraikan // 
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
 // Butiran Aset // 
$colname_rsAset = "-1";
if (isset($_GET['recordID'])) {
  $colname_rsAset = $_GET['recordID'];
}
mysql_select_db($database_sispam, $sispam);
$query_rsAset = sprintf("SELECT * FROM aset WHERE aset_id = %s", GetSQLValueString($colname_rsAset, "int"));
$rsAset = mysql_query($query_rsAset, $sispam) or die(mysql_error());
$row_rsAset = mysql_fetch_assoc($rsAset);
$totalRows_rsAset = mysql_num_rows($rsAset);
 
$pageTitle="Butiran Aset"; ?>
<?php include('lain/pengepala.php'); ?>
    <table border="0" align="center" cellspacing="0" class="tableDetails1" style"margin:0 auto;width 600px;">
      <tr>
        <td style="font-size:100%">
          <fieldset>
          <legend>Butiran Aset</legend>
          <table class="tableDetails">
            <tr>
              <th><span style="font-weight: bold">ID Aset</span></th>
              <td><?php echo $row_rsAset['aset_id']; ?></td>
            </tr>
            <tr>
              <th><span style="font-weight: bold">Jenis Aset</span></th>
              <td><?php echo $row_rsAset['jenis']; ?> &nbsp;</td>
            </tr>         
            <tr>
              <th><span style="font-weight: bold">Status</span></th>
              <td><?php echo $row_rsAset['status']; ?> &nbsp;</td>
            </tr>
            <tr>
              <th><span style="font-weight: bold">Kategori</span></th>
              <td><?php echo $row_rsAset['kategori']; ?> &nbsp;</td>
            </tr>
            <tr>
              <th><span style="font-weight: bold">Vendor</span></th>
              <td><?php echo $row_rsAset['vendor']; ?> &nbsp;</td>
            </tr>
            <tr>
              <th><span style="font-weight: bold">Model</span></th>
              <td><?php echo $row_rsAset['model']; ?> &nbsp;</td>
            </tr>
            <tr>
              <th><span style="font-weight: bold">Nombor Siri</span></th>
              <td><?php echo $row_rsAset['nombor_siri']; ?> &nbsp;</td>
            </tr>
            <tr>
              <th>Tag Aset</th>
              <td><?php echo $row_rsAset['tag_aset']; ?> &nbsp;</td>
            </tr>
            <tr>
              <th>Pesanan Pembelian</th>
              <td><?php echo $row_rsAset['pesanan_pembelian']; ?> &nbsp;</td>
            </tr>            
          </table>
          <hr />
          <table class="tableDetails">
            <tr>
              <th>Status</th>
              <td><?php echo $row_rsAset['status']; ?> &nbsp;</td>
            </tr>
            <tr>
              <th>Tarikh Belian</th>
              <td><?php echo $row_rsAset['tarikh_pembelian']; ?>&nbsp;</td>
            </tr>
            <tr>
              <th>Tarikh Waranti</th>
              <td><?php echo $row_rsAset['waranti']; ?> &nbsp;</td>
            </tr>
            <tr>
              <th>Tarikh Lupus</th>
              <td><?php echo $row_rsAset['tarikh_lupus']; ?>&nbsp;</td>
            </tr>
          </table>
          <hr/>
          <table class="tableDetails">
            <tr>
              <th>Kegunaan</th>
              <td><?php echo $row_rsAset['kegunaan']; ?> &nbsp;</td>
            </tr>
            <tr>
              <th>Biro</th>
              <td><?php echo $row_rsAset['biro']; ?> &nbsp;</td>
            </tr>
            <tr>
              <th>Lokasi</th>
              <td><?php echo $row_rsAset['lokasi']; ?> &nbsp;</td>
            </tr>
            <tr>
              <th valign="top">Harga Perolehan Asal </th>
              <td>
                <pre><?php echo $row_rsAset['harga_perolehan_asal']; ?>&nbsp;</pre>
              </td>
            </tr>
            <tr>
              <th valign="top">Komen</th>
              <td><?php echo $row_rsAset['komen']; ?> &nbsp;</td>
            </tr>
          </table>
          </fieldset>
        </td>
        <td valign="top" style="font-size:90%;">
          <p>&nbsp;</p>
          <fieldset style="width:180px;text-align:left;">
          <legend>Urus Rekod</legend>
          <table class="table1">
            <tr>
              <td class="green">
                <form id="upRecord" name="upRecord" method="post" action="AsetKemaskini.php?recordID=<?php echo $row_rsAset['aset_id']; ?>">
                  <input type="submit" name="Submit2" value="Kemaskini rekod ini" />
                </form>
              </td>
            </tr>
          </table>
          <br/>
          <table class="table1">
            <tr>
              <td class="red">
                <form id="delRecord" name="delRecord" method="post" action="AsetHapus.php?recordID=<?php echo $row_rsAset['aset_id']; ?>">
                  <input name="Submit" type="submit" class="red" value="Hapus rekod ini" />
                </form>
              </td>
            </tr>
          </table>
          </fieldset>
        </td>
      </tr>
    </table>
    <?php include('lain/pengaki.php'); ?>
<?php
mysql_free_result($rsAset);
?>
