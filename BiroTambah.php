<?php require_once('sambung/sispam.php'); ?>
<?php // Tambah Biro // 
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;

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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO biro (biro, komen) VALUES (%s, %s)",
                       GetSQLValueString($_POST['biro'], "text"),
                       GetSQLValueString($_POST['komen'], "text"));

  mysql_select_db($database_sispam, $sispam);
  $Result1 = mysql_query($insertSQL, $sispam) or die(mysql_error());

  $insertGoTo = "BiroSenarai.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
?>
<?php $pageTitle="Tambah Biro"; ?>
<?php include('lain/pengepala.php'); ?>
<!-- Pengesahan untuk borang Biro -->
<script language="JavaScript" type="text/javascript">
function validateForm()
{
	var a=document.forms["form1"]["biro"].value;
	
	if (a==null || a=="")
	{
	alert("Sila masukkan data Biro");
		return false;	
	
	}
}
</script>
<!-- Pengesahan untuk borang Biro -->
<form method="post" name="form1" onsubmit="return validateForm()" action="<?php echo $editFormAction; ?>">
<fieldset>
<legend>Tambah Biro</legend>
<p>
 <label for="Biro">Biro</label> 
 <input type="text" name="biro" value="" size="32">
</p> 
<p>
 <label for="Komen">Komen</label> 
 <textarea name="komen" cols="30" rows="6" id="komen"></textarea>
</p> 
<p class="submit">
 <input type="submit" value="Masuk rekod">
</p>
</fieldset>
<input type="hidden" name="MM_insert" value="form1">
</form>

<?php include('lain/pengaki.php'); ?>