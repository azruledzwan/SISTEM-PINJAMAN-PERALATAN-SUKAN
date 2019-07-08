<?php require_once('Connections/alatansukan.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

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
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
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
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['username'])) {
  $loginUsername=$_POST['username'];
  $password=$_POST['password'];
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "user/index.php";
  $MM_redirectLoginFailed = "logingagal.php";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_alatansukan, $alatansukan);
  
  $LoginRS__query=sprintf("SELECT username, password FROM login WHERE username=%s AND password=%s",
    GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $alatansukan) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
     $loginStrGroup = "";
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>e-ALATAN SUKAN</title>
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
</head>

<body ><h1 style="font-size: 40px; text-align: center;"><span style="font-size: 24px; text-align: center;"></span>SISTEM PINJAMAN PERALATAN SUKAN</h1>
<p style="font-size: 24px; text-align: center;">SMK TUANKU LAILATUL SHAHREEN</p>
<center>
  <center>
  <p><a href="index.php">LAMAN UTAMA</a> | <a href="daftarlogin.php">DAFTAR PENGGUNA</a></p>
  <p>&nbsp;</p>
  <p><strong>LOG MASUK</strong></p>
</center>
</center>
<form action="<?php echo $loginFormAction; ?>" method="POST" name="form1">
<table width="500" align="center" >
  <tr>
    <td width="86">Username</td>
    <td width="144"><span id="sprytextfield2">
      <label>
        <input type="text" name="username" id="username" />
      </label>
      <span class="textfieldRequiredMsg">Medan ini perlu diisi</span></span></td>
  </tr>
  <tr>
    <td>Password</td>
    <td><span id="sprytextfield3">
      <label>
        <input type="password" name="password" id="password" />
      </label>
      <span class="textfieldRequiredMsg">Medan ini perlu diisi</span></span></td>
  </tr>
  <tr>
    <td>No. Kad Pengenalan</td>
    <td><span id="sprytextfield1">
      <label>
        <input type="text" name="nokpuser" id="nokpuser" />
        <span class="textfieldRequiredMsg">Medan ini perlu diisi</span><span class="textfieldMinCharsMsg">Minimum number of characters not met.</span><span class="textfieldMaxCharsMsg">Exceeded maximum number of characters.</span></label>
</span></td>
  </tr>
  <tr>
    <td colspan="2"><br /><center><input type="submit" name="button" id="button" value="LOG MASUK" /></center><br /></td>
    </tr>
</table>
<p style="text-align: center; font-size: 18px;"><a href="daftarlogin.php">Daftar</a> Pengguna Baharu</p>

</form>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none", {validateOn:["change"], minChars:12, maxChars:12});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3");
</script>
</body>
</html>