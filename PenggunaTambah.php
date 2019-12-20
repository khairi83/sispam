<?php require_once('sambung/sispam.php'); ?>
<?php // Tambah Pengguna // 
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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "addUser")) {
  $insertSQL = sprintf("INSERT INTO pengguna (nama_pengguna, katalaluan, nama_penuh, jawatan, `peranan`) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['nama_pengguna'], "text"),
                       GetSQLValueString($_POST['katalaluan'], "text"),
                       GetSQLValueString($_POST['nama_penuh'], "text"),
                       GetSQLValueString($_POST['jawatan'], "text"),
                       GetSQLValueString($_POST['peranan'], "text"));

  mysql_select_db($database_sispam, $sispam);
  $Result1 = mysql_query($insertSQL, $sispam) or die(mysql_error());

  $insertGoTo = "PenggunaSenarai.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
?>
<?php $pageTitle="Tambah Pengguna"; ?>
<?php include('lain/pengepala.php'); ?>
<script type="text/javascript">

</script>
<form action="<?php echo $editFormAction; ?>" method="POST" name="addUser" onsubmit="MM_validateForm('nama_pengguna','','R','katalaluan','','R');return document.MM_returnValue">
<fieldset>
<legend>Tambah Pengguna</legend>
<p>
 <label for="First Name">Nama Penuh</label> 
 <input name="nama_penuh" type="text" id="nama_penuh" size="32" maxlength="100" />
</p> 
<p>
 <label for="First Name">Jawatan</label> 
 <input name="jawatan" type="text" id="jawatan" value="" size="32" maxlength="100" />
</p> 
<p>
 <label for="First Name">Nama Pengguna</label> 
 <input name="nama_pengguna" type="text" id="nama_pengguna" value="" size="32" maxlength="30" />
</p> 
<p>
 <label for="First Name">Katalaluan</label> 
 <input name="katalaluan" type="text" id="katalaluan" value="" size="32" />
</p> 
<p>
 <label for="First Name">Peranan</label> 
 <select name="peranan">
            <option selected="selected"> -- Pilih Peranan --</option>
            <option value="pengurus">Pengurus - Kebenaran Penuh</option>
            <option value="operator">Operator - Mengurus Aset, Laporan</option>
           </select></p> 
<p>

<p class="submit">
 <input type="submit" value="Tambah Pengguna"> 
</p>
</fieldset>

      <input type="hidden" name="MM_insert" value="addUser">
</form>
<?php include('lain/pengaki.php'); ?>