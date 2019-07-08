<?php require_once('../Connections/alatansukan.php'); ?>
<?php require_once('../Connections/alatansukan.php'); ?>
<?php require_once('../Connections/alatansukan.php');?>
<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "../index.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {
  $insertSQL = sprintf("INSERT INTO login (idpengguna, username, password, nokp) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['idpengguna'], "int"),
                       GetSQLValueString($_POST['username'], "text"),
                       GetSQLValueString($_POST['password'], "text"),
                       GetSQLValueString($_POST['nokp'], "text"));

  mysql_select_db($database_alatansukan, $alatansukan);
  $Result1 = mysql_query($insertSQL, $alatansukan) or die(mysql_error());

  $insertGoTo = "berjayadaftarlogin.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO pinjaman (idpinjaman, nokppeminjam, kodperalatan, tujuanpinjaman, kuantitipinjam, tarikhpinjam, status) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['idpinjaman'], "int"),
                       GetSQLValueString($_POST['nokppeminjam'], "text"),
                       GetSQLValueString($_POST['kodperalatan'], "text"),
                       GetSQLValueString($_POST['tujuanpinjaman'], "text"),
                       GetSQLValueString($_POST['kuantitipinjam'], "int"),
					   GetSQLValueString($_POST['tarikhpinjam'], "date"),
                       GetSQLValueString($_POST['status'], "text"));

  mysql_select_db($database_alatansukan, $alatansukan);
  $Result1 = mysql_query($insertSQL, $alatansukan) or die(mysql_error());

  $insertGoTo = "berjayapinjam.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_alatansukan, $alatansukan);
$query_Recordset1 = "SELECT idpinjaman, nokppeminjam, kodperalatan, tujuanpinjaman, kuantitipinjam, tarikhpinjam FROM pinjaman";
$Recordset1 = mysql_query($query_Recordset1, $alatansukan) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_alatansukan, $alatansukan);
$query_Recordset2 = "SELECT * FROM peminjam";
$Recordset2 = mysql_query($query_Recordset2, $alatansukan) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

mysql_select_db($database_alatansukan, $alatansukan);
$query_Recordset3 = "SELECT * FROM peralatan";
$Recordset3 = mysql_query($query_Recordset3, $alatansukan) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>e-ALATAN SUKAN</title>
<style type="text/css">
.logout {
	color: #F00;
}
.logout a {
	background-color: #F00;
}
</style>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
</head>

<body ><h1 style="font-size: 40px; text-align: center;"><span style="font-size: 24px; text-align: center;"></span>SISTEM PINJAMAN PERALATAN SUKAN</h1>
<p style="font-size: 24px; text-align: center;">SMK TUANKU LAILATUL SHAHREEN</p>
<center>
  <p><a href="index.php">LAMAN UTAMA</a> | <a href="daftarpeminjam.php">DAFTAR PEMINJAM</a> | <a href="daftarperalatan.php">DAFTAR PERALATAN</a> | <a href="pinjamperalatan.php">PINJAM PERALATAN</a> | <a href="pulangperalatan.php">PULANG PERALATAN</a> | <a href="carian.php">CARIAN</a> | <a href="laporan.php">LAPORAN</a> | <span class="logout"><a href="<?php echo $logoutAction ?>">LOG KELUAR</a></span></p>
  <p>&nbsp;</p>
  <p><strong>BORANG PINJAMAN PERALATAN SUKAN</strong></p>
</center>
<form action="<?php echo $editFormAction; ?>" method="post" name="form2" id="form2">
  <input type="hidden" name="MM_insert" value="form2" />
</form>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Nokp Peminjam:</td>
      <td><label>
        <select name="nokppeminjam" id="nokppeminjam">
          <?php
do {  
?>
          <option value="<?php echo $row_Recordset2['nokppeminjam']?>"><?php echo $row_Recordset2['nokppeminjam']?></option>
          <?php
} while ($row_Recordset2 = mysql_fetch_assoc($Recordset2));
  $rows = mysql_num_rows($Recordset2);
  if($rows > 0) {
      mysql_data_seek($Recordset2, 0);
	  $row_Recordset2 = mysql_fetch_assoc($Recordset2);
  }
?>
        </select>
      </label></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Kod Peralatan:</td>
      <td><label>
        <select name="kodperalatan" id="kodperalatan">
          <?php
do {  
?>
          <option value="<?php echo $row_Recordset3['kodperalatan']?>"><?php echo $row_Recordset3['kodperalatan']?></option>
          <?php
} while ($row_Recordset3 = mysql_fetch_assoc($Recordset3));
  $rows = mysql_num_rows($Recordset3);
  if($rows > 0) {
      mysql_data_seek($Recordset3, 0);
	  $row_Recordset3 = mysql_fetch_assoc($Recordset3);
  }
?>
        </select>
      </label></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Tujuan Pinjaman:</td>
      <td><span id="sprytextfield3">
        <input type="text" name="tujuanpinjaman" value="" size="32" />
      <span class="textfieldRequiredMsg">A value is required.</span></span></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Kuantiti Pinjam:</td>
      <td><span id="sprytextfield4">
        <input type="text" name="kuantitipinjam" value="" size="32" />
      <span class="textfieldRequiredMsg">A value is required.</span></span></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Tarikh Pinjam:</td>
      <td><input type="date" name="tarikhpinjam" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td colspan="2" align="right" nowrap="nowrap"><br /><center><input type="submit" name="button" id="button" value="HANTAR" /></center><br /></td>
    </tr>
  </table>
  <input type="hidden" name="idpinjaman" value="" />
   <input type="hidden" name="status" value="BELUM PULANG" />
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<p>&nbsp;</p>
<p>&nbsp;</p>
<script type="text/javascript">
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3");
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4");
</script>
</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);

mysql_free_result($Recordset3);

?>