<?php require_once('sambung/sispam.php'); ?>
<?php // Log Masuk // 
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

mysql_select_db($database_sispam, $sispam);
$query_rsNamaMasjid = "SELECT * FROM nama_masjid";
$rsNamaMasjid = mysql_query($query_rsNamaMasjid, $sispam) or die(mysql_error());
$row_rsNamaMasjid = mysql_fetch_assoc($rsNamaMasjid);
$totalRows_rsNamaMasjid = mysql_num_rows($rsNamaMasjid);
?><?php
// *** Mengesahkan permintaan untuk log masuk ke laman web ini.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['myusername'])) {
  $loginUsername=$_POST['myusername'];
  $password=$_POST['mypassword'];
  $MM_fldUserAuthorization = "peranan";
  $MM_redirectLoginSuccess = "index.php";
  $MM_redirectLoginFailed = "Masuk.php";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_sispam, $sispam);
  	
  $LoginRS__query=sprintf("SELECT nama_pengguna, katalaluan, peranan FROM pengguna WHERE nama_pengguna=%s AND katalaluan=%s",
  GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $sispam) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
    
    $loginStrGroup  = mysql_result($LoginRS,0,'peranan');
    
    //mengisytiharkan dua pembolehubah sesi dan menentukan mereka peranan
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo $row_rsNamaMasjid['masjid_nama']; ?> Sistem Pengurusan Aset Masjid - Masuk</title>
<!--/* Alatan Pengurus Aset */ -->
<link rel="shortcut icon" href="sispam/favicon.ico" type="image/x-icon" />
<link rel="icon" href="sispam/favicon.ico" type="image/x-icon" />
<link href="lain/sispam_utama.css" rel="stylesheet" type="text/css" media="all" />
</head>
<body>
<div id="container">
  <div id="header"><img src="imej/logo.gif" alt="" /></div>
  <div id="navcontainer">
 	<ul id="navlist">
    <li><a title="">Log Masuk & Masukkan Maklumat</a></li>
    </ul>
  </div>
  <div id="mainContent">
    <div style="padding:60px 0;">
      <form ACTION="<?php echo $loginFormAction; ?>" name="sispamLogin" method="POST">
        <fieldset>
        <legend> Sila Masukkan Nama Pengguna & Kata Laluan </legend>
        <p>
          <label for="Nama_pengguna">Nama Pengguna</label>
          <input name="myusername" type="text" id="myusername" size="24" />
        </p>
        <p>
          <label for="Nama_pengguna">Kata Laluan</label>
          <input name="mypassword" type="password" id="mypassword" size="24" />
        </p>
        <p class="submit">
          <input type="submit" name="Submit" value="Log Masuk" />
        </p>
		<br />
        </fieldset>
      </form>
    </div>
</div>
  <div id="footer">
    <p><?php echo date("D M dS, Y - h:i a"); ?><br />
    <em>Sistem Pengurusan Aset Masjid</a></em></p>
  </div>
</div>

</body>
</html>
<?php
mysql_free_result($rsNamaMasjid);
?>
